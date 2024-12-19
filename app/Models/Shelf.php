<?php

namespace App\Models;

use App\Enums\StocktakingStatus;
use App\Observers\ShelfObserver;
use App\Models\Concerns\Filterable;
use App\Models\Filters\ShelfFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[ObservedBy(ShelfObserver::class)]
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
        'description',
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

    public function employees(): BelongsToMany
    {
        return $this->belongsToMany(
                related: Employee::class,
                table: 'employee_shelf',
                foreignPivotKey: 'shelf_id',
                relatedPivotKey: 'employee_id',
            )
            ->withTimestamps();
    }

    public function stocktakings()
    {
        return $this->hasMany(Stocktaking::class);
    }

    /**
     * Scopes
     */
    public function scopeForEmployee(Builder $query, $employeeId): Builder
    {
        return $query->whereHas('employees', fn($q) =>
            $q->where('employees.id', $employeeId)
        );
    }

    /**
     * Accessors
     */
    public function descriptiveName(): Attribute
    {
        return Attribute::make(
            get: fn() => filled($this->description) ? $this->description : $this->name,
        );
    }

    /**
     * Methods
     */
    public function hasPendingStocktaking(): bool
    {
        return $this->stocktakings()
            ->where('status', StocktakingStatus::PENDING->value)
            ->exists();
    }
}
