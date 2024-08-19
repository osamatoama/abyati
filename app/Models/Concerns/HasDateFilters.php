<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;

trait HasDateFilters
{
    public function scopeFilterByDate(Builder $query, array $filters = [], string $col = 'created_at')
    {
        return $query
            ->when(
                ($filters['time'] ?? false) === 'this_week',
                fn (Builder $query): Builder => $query->whereBetween($col, [now()->startOfWeek(), now()->endOfWeek()]),
            )
            ->when(
                ($filters['time'] ?? false) === 'this_month',
                fn (Builder $query): Builder => $query->whereBetween($col, [now()->startOfMonth(), now()->endOfMonth()]),
            )
            ->when(
                ($filters['time'] ?? false) === 'this_year',
                fn (Builder $query): Builder => $query->whereBetween($col, [now()->startOfYear(), now()->endOfYear()]),
            )
            ->when(
                ($filters['time'] ?? false) === 'specific' && $filters['date_from'],
                fn (Builder $query): Builder => $query->where($col, '>=', $filters['date_from']),
            )
            ->when(
                ($filters['time'] ?? false) === 'specific' && $filters['date_to'],
                fn (Builder $query): Builder => $query->where($col, '<=', $filters['date_to']),
            );
    }
}
