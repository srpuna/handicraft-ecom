<?php

namespace App\Models;

use App\Models\ShippingZone;
use App\Models\SiteSetting;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public const PURCHASE_TYPE_NORMAL = 'normal';
    public const PURCHASE_TYPE_SALE = 'sale';

    public const SPIRITUAL_OPTION_FILLING_ONLY = 'filling_only';
    public const SPIRITUAL_OPTION_BLESSING_ONLY = 'blessing_only';
    public const SPIRITUAL_OPTION_BOTH = 'both';

    public const SPIRITUAL_OPTION_LABELS = [
        self::SPIRITUAL_OPTION_FILLING_ONLY => 'Filling Only',
        self::SPIRITUAL_OPTION_BLESSING_ONLY => 'Blessing Only',
        self::SPIRITUAL_OPTION_BOTH => 'Both Filling & Blessing',
    ];

    protected $fillable = [
        'name',
        'slug',
        'description',
        'long_description',
        'price',
        'discount_price',
        'stock',
        'min_quantity',
        'material',
        'category_id',
        'sub_category_id',
        'sku',
        'length',
        'width',
        'height',
        'weight',
        'main_image',
        'secondary_image',
        'images',
        'has_spiritual_options',
        'price_filling_only',
        'price_blessing_only',
        'price_both',
        'is_order_now_enabled',
        'is_new_arrival',
        'is_featured',
        'is_recommended',
        'is_on_sale',
        'carousel_priority'
    ];

    protected $guarded = [];

    protected $casts = [
        'images' => 'array',
        'has_spiritual_options' => 'boolean',
        'price_filling_only' => 'decimal:2',
        'price_blessing_only' => 'decimal:2',
        'price_both' => 'decimal:2',
        'is_new_arrival' => 'boolean',
        'is_featured' => 'boolean',
        'is_recommended' => 'boolean',
        'is_on_sale' => 'boolean',
        'is_order_now_enabled' => 'boolean',
    ];

    // Scopes for carousel queries
    public function scopeNewArrivals($query)
    {
        return $query->where('is_new_arrival', true)->orderBy('carousel_priority')->orderBy('created_at', 'desc');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)->orderBy('carousel_priority')->orderBy('created_at', 'desc');
    }

    public function scopeRecommended($query)
    {
        return $query->where('is_recommended', true)->orderBy('carousel_priority')->orderBy('created_at', 'desc');
    }

    public function scopeOnSale($query)
    {
        return $query->where('is_on_sale', true)->whereNotNull('discount_price')->orderBy('carousel_priority')->orderBy('created_at', 'desc');
    }

    public function getEffectivePriceAttribute()
    {
        return $this->discount_price ?? $this->price;
    }

    public function hasSalePrice(): bool
    {
        return $this->discount_price !== null && (float) $this->discount_price >= 0;
    }

    public function getPurchaseTypeOptionsAttribute(): array
    {
        return [
            self::PURCHASE_TYPE_NORMAL => [
                'label' => 'Normal',
                'price' => (float) $this->price,
                'enabled' => true,
            ],
            self::PURCHASE_TYPE_SALE => [
                'label' => 'Sale',
                'price' => $this->hasSalePrice() ? (float) $this->discount_price : (float) $this->price,
                'enabled' => $this->hasSalePrice(),
            ],
        ];
    }

    public function getSpiritualOptionPricesAttribute(): array
    {
        return [
            self::SPIRITUAL_OPTION_FILLING_ONLY => (float) ($this->price_filling_only ?? 0),
            self::SPIRITUAL_OPTION_BLESSING_ONLY => (float) ($this->price_blessing_only ?? 0),
            self::SPIRITUAL_OPTION_BOTH => (float) ($this->price_both ?? 0),
        ];
    }

    public function getPurchasePrice(string $purchaseType = self::PURCHASE_TYPE_NORMAL): float
    {
        if ($purchaseType === self::PURCHASE_TYPE_SALE && $this->hasSalePrice()) {
            return (float) $this->discount_price;
        }

        return (float) $this->price;
    }

    public function getSpiritualOptionPrice(?string $option): float
    {
        if (!$this->has_spiritual_options || empty($option)) {
            return 0.0;
        }

        return $this->spiritual_option_prices[$option] ?? 0.0;
    }

    public function getSpiritualOptionLabel(?string $option): ?string
    {
        return $option ? (self::SPIRITUAL_OPTION_LABELS[$option] ?? $option) : null;
    }

    // Format dimension value - remove .00 if whole number
    public function formatDimension($value)
    {
        if ($value == null) return 'N/A';
        return $value == floor($value) ? (int)$value : rtrim(rtrim(number_format($value, 2), '0'), '.');
    }

    public function getFormattedLengthAttribute()
    {
        return $this->formatDimension($this->length);
    }

    public function getFormattedWidthAttribute()
    {
        return $this->formatDimension($this->width);
    }

    public function getFormattedHeightAttribute()
    {
        return $this->formatDimension($this->height);
    }

    public function getFormattedWeightAttribute()
    {
        if ($this->weight == null) return 'N/A';
        return $this->weight == floor($this->weight) ? (int)$this->weight : rtrim(rtrim(number_format($this->weight, 3), '0'), '.');
    }

    /**
     * Accessor for main_image to ensure it returns a full URL.
     */
    public function getMainImageAttribute($value)
    {
        return self::mediaUrl($value);
    }

    /**
     * Accessor for secondary_image to ensure it returns a full URL.
     */
    public function getSecondaryImageAttribute($value)
    {
        return self::mediaUrl($value);
    }

    /**
     * Accessor for images array to ensure each item returns a full URL.
     */
    public function getImagesAttribute($value)
    {
        if (!$value) {
            return [];
        }

        $images = is_string($value) ? json_decode($value, true) : $value;

        if (!is_array($images)) {
            return [];
        }

        // Filter out any false/null/non-string entries that may have been saved
        // from a CSV import or earlier bug, then resolve each to a full URL.
        return array_values(array_filter(
            array_map(function ($image) {
                if (!is_string($image) || $image === '') {
                    return null;
                }
                return self::mediaUrl($image);
            }, $images),
            fn($url) => $url !== null && $url !== ''
        ));
    }

    /**
     * Helper to resolve media URLs.
     *
     * On localhost  (MEDIA_DISK=public): uses the local public disk URL (http://localhost/storage/...).
     *               storage:link must be in place.
     * On production (MEDIA_DISK=s3):    builds URL from AWS_URL (CDN base) → no SDK needed.
     *
     * No AWS_URL fallback on the local public disk — that caused localhost to silently
     * serve images from production storage, mixing environments.
     */
    public static function mediaUrl(?string $path): string
    {
        if (empty($path)) return '';
        if (filter_var($path, FILTER_VALIDATE_URL)) return $path;

        $disk = self::mediaDisk();

        // S3/R2 disk: build URL directly from AWS_URL (CDN base), skipping the SDK entirely.
        if ($disk === 's3') {
            $baseUrl = config('filesystems.disks.s3.url') ?: config('filesystems.disks.s3.endpoint');
            if ($baseUrl) {
                return rtrim($baseUrl, '/') . '/' . ltrim($path, '/');
            }
        }

        // Local public disk: serve via storage:link. No production URL fallback.
        return rescue(
            fn() => \Illuminate\Support\Facades\Storage::disk($disk)->url($path),
            fn() => asset('storage/' . $path)
        );
    }

    /**
     * Determine which filesystem disk to use for media uploads and URL generation.
     *
     * - Localhost:   MEDIA_DISK=public (set in .env) → 'public' disk, no AWS credentials needed.
     * - Production:  MEDIA_DISK=s3    (set in production env) → 's3' disk, credentials from env.
     *
     * Falls back to FILESYSTEM_DISK if MEDIA_DISK is not set:
     *   'local' or 'public' → uses 'public' disk.
     *   anything else (e.g. 's3') → uses that disk.
     */
    public static function mediaDisk(): string
    {
        // MEDIA_DISK explicit override takes priority.
        $mediaDisk = config('media.disk') ?: env('MEDIA_DISK');
        if ($mediaDisk) {
            return $mediaDisk;
        }

        $default = config('filesystems.default', 'local');
        return ($default === 'local' || $default === 'public') ? 'public' : $default;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function inquiries()
    {
        return $this->hasMany(Inquiry::class);
    }
}
