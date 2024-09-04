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
    ];


    /**
     * Relations
     */
    public function optionValues(): BelongsToMany
    {
        return $this->belongsToMany(OptionValue::class, 'product_variant_option_values', 'product_variant_id', 'option_value_id')
            ->withPivot('option_id')
            ->withTimestamps();
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
