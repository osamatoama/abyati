<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class StocktakingIssue extends Model
{
    use SoftDeletes;

    /**
     * Config
     */
    protected $table = 'stocktaking_issues';

    protected $fillable = [
        'stocktaking_id',
        'product_id',
        'type',
        'employee_note',
        'resolved',
    ];

    protected function casts(): array
    {
        return [
            'resolved' => 'boolean',
        ];
    }

    /**
     * Relationships
     */
    public function stocktaking()
    {
        return $this->belongsTo(Stocktaking::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Scopes
     */
    public function scopeForStocktaking(Builder $query, Stocktaking|string|int $stocktaking): Builder
    {
        $stocktakingId = $stocktaking instanceof Stocktaking ? $stocktaking->id : $stocktaking;

        return $query->where('stocktaking_id', $stocktakingId);
    }
}
