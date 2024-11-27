<?php

namespace App\Models\Filters;

class ProductFilter extends BaseFilters
{
    protected $filters = [
        'store_id',
        'store_ids',
        'category_id',
        'category_ids',
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

    protected function categoryId($value)
    {
        return $this->builder->when($value, function ($query) use ($value) {
            $query->whereHas('categories', function ($q) use ($value) {
                $q->where('categories.id', $value);
            });
        });
    }

    protected function categoryIds($value)
    {
        return $this->builder->when($value, function ($query) use ($value) {
            $query->whereHas('categories', function ($q) use ($value) {
                $q->whereIn('categories.id', $value);
            });
        });
    }
}

