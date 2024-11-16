<?php

namespace App\Models\Filters;

class ShelfFilter extends BaseFilters
{
    protected $filters = [
        'warehouse_id',
        'warehouse_ids',
    ];

    protected function warehouseId($value)
    {
        return $this->builder->when($value, function ($query) use ($value) {
            $query->where('shelves.warehouse_id', $value);
        });
    }

    protected function warehouseIds($value)
    {
        return $this->builder->when($value, function ($query) use ($value) {
            $query->whereIn('shelves.warehouse_id', $value);
        });
    }
}

