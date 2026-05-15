<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'product_snapshot',
        'purchase_type',
        'spiritual_option',
        'option_price',
        'quantity',
        'unit_price',
        'weight_kg',
        'item_discount_type',
        'item_discount_value',
        'item_discount_amount',
        'line_total',
    ];

    protected $casts = [
        'product_snapshot' => 'array',
        'quantity' => 'integer',
        'option_price' => 'decimal:2',
        'unit_price' => 'decimal:2',
        'weight_kg' => 'decimal:3',
        'item_discount_value' => 'decimal:2',
        'item_discount_amount' => 'decimal:2',
        'line_total' => 'decimal:2',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Calculate the item discount amount and line total
     */
    public function calculateTotals(): void
    {
        $subtotal = $this->unit_price * $this->quantity;

        if ($this->item_discount_type === 'percent') {
            $this->item_discount_amount = round($subtotal * ($this->item_discount_value / 100), 2);
        } elseif ($this->item_discount_type === 'fixed') {
            $this->item_discount_amount = min($this->item_discount_value, $subtotal);
        } else {
            $this->item_discount_amount = 0;
        }

        $this->line_total = max(0, $subtotal - $this->item_discount_amount);
    }

    /**
     * Get product name from snapshot or product relation
     */
    public function getProductNameAttribute(): string
    {
        return $this->product_snapshot['name'] ?? ($this->product?->name ?? 'Unknown Product');
    }

    /**
     * Get product SKU from snapshot
     */
    public function getProductSkuAttribute(): string
    {
        return $this->product_snapshot['sku'] ?? '-';
    }

    public function getPurchaseTypeLabelAttribute(): string
    {
        return $this->purchase_type === Product::PURCHASE_TYPE_SALE ? 'Sale' : 'Normal';
    }

    public function getSpiritualOptionLabelAttribute(): ?string
    {
        if (empty($this->spiritual_option)) {
            return null;
        }

        return Product::SPIRITUAL_OPTION_LABELS[$this->spiritual_option] ?? $this->spiritual_option;
    }

    public function getBaseUnitPriceAttribute(): float
    {
        return max(0, (float) $this->unit_price - (float) $this->option_price);
    }
}
