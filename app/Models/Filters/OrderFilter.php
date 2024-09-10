<?php

namespace App\Models\Filters;

class OrderFilter extends BaseFilters
{
    protected $filters = [
        'status',
        'from_date',
        'to_date',
    ];

    protected function status($value)
    {
        return $this->builder->when($value, function ($query) use ($value) {
            $query->where('orders.status_id', $value);
        });
    }

    protected function fromDate($value)
    {
        return $this->builder->when($value, function ($query) use ($value) {
            $query->whereDate('orders.date', '>=', $value);
        });
    }

    protected function toDate($value)
    {
        return $this->builder->when($value, function ($query) use ($value) {
            $query->whereDate('orders.date', '<=', $value);
        });
    }
}

