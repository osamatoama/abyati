<?php

namespace App\Models\Filters;

class OrderFilter extends BaseFilters
{
    protected $filters = [
        'status',
        'from_date',
        'to_date',
        'store_id',
        'store_ids',
        'completion_status',
        'completion_statuses',
        'is_assigned',
        'employee_id',
        'employee_ids',
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

    protected function storeId($value)
    {
        return $this->builder->when($value, function ($query) use ($value) {
            $query->where('orders.store_id', $value);
        });
    }

    protected function storeIds($value)
    {
        return $this->builder->when($value, function ($query) use ($value) {
            $query->whereIn('orders.store_id', $value);
        });
    }

    protected function completionStatus($value)
    {
        return $this->builder->when($value, function ($query) use ($value) {
            $query->where('orders.completion_status', $value);
        });
    }

    protected function completionStatuses($value)
    {
        return $this->builder->when($value, function ($query) use ($value) {
            $query->whereIn('orders.completion_status', $value);
        });
    }

    protected function isAssigned($value)
    {
        if ($value === '1') {
            if (auth('employee')->check()) {
                return $this->builder->where('orders.employee_id', auth('employee')->id());
            }

            return $this->builder->whereNotNull('orders.employee_id');
        }

        if ($value === '0') {
            return $this->builder->whereNull('orders.employee_id');
        }

        return $this->builder;
    }

    protected function employeeId($value)
    {
        return $this->builder->when($value, function ($query) use ($value) {
            $query->where('orders.employee_id', $value);
        });
    }

    protected function employeeIds($value)
    {
        return $this->builder->when($value, function ($query) use ($value) {
            $query->whereIn('orders.employee_id', $value);
        });
    }
}

