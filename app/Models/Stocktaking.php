<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Concerns\BelongsToEmployee;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'audited_at',
    ];

    protected function casts(): array
    {
        return [
            'audited_at' => 'datetime',
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

    /**
     * Scopes
     */
    public function scopeForShelf(Builder $query, Shelf|string|int $shelf): Builder
    {
        $shelfId = $shelf instanceof Shelf ? $shelf->id : $shelf;

        return $query->where('shelf_id', $shelfId);
    }
}
