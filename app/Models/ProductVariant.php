<?php

namespace App\Models;

use App\Models\Concerns\BelongsToStore;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ProductVariant extends Model
{
    use SoftDeletes;
    use BelongsToStore;

    /**
     * Config
     */
    protected $fillable = [
        'remote_id',
        'store_id',
        'product_id',
        'sku',
        'barcode',
        'stock_quantity',
        'unlimited_quantity',
    ];

    protected $casts = [
        'stock_quantity' => 'integer',
        'unlimited_quantity' => 'boolean',
    ];

    /**
     * Relations
     */
    public function optionValues(): BelongsToMany
    {
        return $this->belongsToMany(
            related: OptionValue::class,
            table: 'product_variant_option_values',
            foreignPivotKey: 'product_variant_id',
            relatedPivotKey: 'option_value_id',
        );
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'product_variant_id');
    }


    /**
     * Accessors
     */
    public function getDescriptionAttribute()
    {
        return $this->optionValues
            ->map(
                fn($optionValue) => $optionValue->option->name . ': ' . $optionValue->name
            )
            ->implode(' - ');
    }

    /**
     * Scopes
     */
    public function scopeForProduct($query, string $productId)
    {
        $query->where('product_id', $productId);
    }
}
