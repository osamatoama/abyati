<?php

namespace App\Models;

use App\Models\Concerns\Filterable;
use App\Models\Filters\ShelfFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Shelf extends Model
{
    use SoftDeletes;
    use Filterable;

    /**
     * Config
     */
    protected $table = 'shelves';

    protected $fillable = [
        'warehouse_id',
        'aisle',
        'name',
        'order',
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    protected $filter = ShelfFilter::class;

    /**
     * Relationships
     */
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(
                related: Product::class,
                table: 'product_shelf',
                foreignPivotKey: 'shelf_id',
                relatedPivotKey: 'product_id',
            )
            ->withTimestamps();
    }
}
