<?php

namespace App\Models;

use App\Enums\ProductType;
use App\Models\Concerns\Filterable;
use App\Models\Filters\ProductFilter;
use App\Models\Concerns\BelongsToStore;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Product extends Model
{
    use SoftDeletes;
    use BelongsToStore;
    use Filterable;

    /**
     * Config
     */
    protected $fillable = [
        'remote_id',
        'store_id',
        'name',
        'sku',
        'type',
        'main_image',
        'status',
        'quantity',
        'unlimited_quantity',
        'price',
        'sale_price',
        'regular_price',
        'currency',
        'should_sync',
        'synced',
    ];

    protected $casts = [
        'id' => 'integer',
        'store_id' => 'integer',
        'quantity' => 'integer',
        'unlimited_quantity' => 'boolean',
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'regular_price' => 'decimal:2',
        'should_sync' => 'boolean',
        'synced' => 'boolean',
    ];

    protected $filter = ProductFilter::class;

    /**
     * Relations
     */
    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function categories()
    {
        return $this->belongsToMany(
            related: Category::class,
            table: 'category_product',
        );
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function options(): HasMany
    {
        return $this->hasMany(Option::class);
    }

    public function optionValues(): HasManyThrough
    {
        return $this->hasManyThrough(OptionValue::class, Option::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function shelves(): BelongsToMany
    {
        return $this->belongsToMany(
                related: Shelf::class,
                table: 'product_shelf',
                foreignPivotKey: 'product_id',
                relatedPivotKey: 'shelf_id',
            )
            ->withTimestamps();
    }

    public function quantities(): HasMany
    {
        return $this->hasMany(ProductQuantity::class);
    }

    public function groupItems()
    {
        return $this->hasMany(ProductGroup::class, 'group_id');
    }

    public function partOfGroups()
    {
        return $this->hasMany(ProductGroup::class, 'product_id');
    }

    /**
     * Methods
     */
    public function isGroup()
    {
        return $this->type === ProductType::GROUP_PRODUCTS->value;
    }

    public function markAsSynced()
    {
        $this->update([
            'should_sync' => false,
            'synced' => true,
        ]);
    }
}
