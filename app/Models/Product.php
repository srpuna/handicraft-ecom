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
        return media_url($value);
    }

    /**
     * Accessor for secondary_image to ensure it returns a full URL.
     */
    public function getSecondaryImageAttribute($value)
    {
        return media_url($value);
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

        return array_map(function ($image) {
            return media_url($image);
        }, $images);
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
