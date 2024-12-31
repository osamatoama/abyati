<?php

namespace App\Models;

use App\Enums\StocktakingStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Concerns\BelongsToEmployee;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Stocktaking extends Model
{
    use SoftDeletes;
    use BelongsToEmployee;

    /**
     * Config
     */
    protected $table = 'stocktakings';

    protected $fillable = [
        'shelf_id',
        'employee_id',
        'status',
        'started_at',
        'finished_at',
    ];

    protected function casts(): array
    {
        return [
            'started_at' => 'datetime',
            'finished_at' => 'datetime',
        ];
    }

    /**
     * Relationships
     */
    public function shelf(): BelongsTo
    {
        return $this->belongsTo(Shelf::class);
    }

    public function issues(): HasMany
    {
        return $this->hasMany(
            related: StocktakingIssue::class,
            foreignKey: 'stocktaking_id',
        );
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(
                related: Product::class,
                table: 'stocktaking_product',
            )
            ->withPivot([
                'confirmed',
                'has_issue',
            ])
            ->withTimestamps();
    }

    /**
     * Scopes
     */
    public function scopeForShelf(Builder $query, Shelf|string|int $shelf): Builder
    {
        $shelfId = $shelf instanceof Shelf ? $shelf->id : $shelf;

        return $query->where('shelf_id', $shelfId);
    }

    /**
     * Methods
     */
    public function isExecuted(): bool
    {
        return $this->products->every(fn(Product $product) =>
            $product->pivot->confirmed || $product->pivot->has_issue
        );
    }

    public function isPending(): bool
    {
        return $this->status === StocktakingStatus::PENDING->value;
    }

    public function isCompleted(): bool
    {
        return $this->status === StocktakingStatus::COMPLETED->value;
    }

    public function setAsPending(): void
    {
        $this->update([
            'status' => StocktakingStatus::PENDING,
        ]);
    }

    public function setAsCompleted(): void
    {
        $this->update([
            'status' => StocktakingStatus::COMPLETED,
            'finished_at' => now(),
        ]);
    }
}
