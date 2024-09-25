<?php

namespace App\Models\Filters;

class ProductFilter extends BaseFilters
{
    protected $filters = [
        'store_id',
        'store_ids',
    ];

    protected function storeId($value)
    {
        return $this->builder->when($value, function ($query) use ($value) {
            $query->where('products.store_id', $value);
        });
    }

    protected function storeIds($value)
    {
        return $this->builder->when($value, function ($query) use ($value) {
            $query->whereIn('products.store_id', $value);
        });
    }
}

