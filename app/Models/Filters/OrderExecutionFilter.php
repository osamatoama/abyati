<?php

namespace App\Models\Filters;

class OrderExecutionFilter extends BaseFilters
{
    protected $filters = [
        'from_date',
        'to_date',
        'employee_id',
        'status',
    ];

    protected function fromDate($value)
    {
        return $this->builder->when($value, function ($query) use ($value) {
            $query->whereDate('order_executions.started_at', '>=', $value);
        });
    }

    protected function toDate($value)
    {
        return $this->builder->when($value, function ($query) use ($value) {
            $query->whereDate('order_executions.started_at', '<=', $value);
        });
    }

    protected function employeeId($value)
    {
        return $this->builder->when($value, function ($query) use ($value) {
            $query->where('order_executions.employee_id', $value);
        });
    }

    protected function status($value)
    {
        if ($value == 'completed') {
            return $this->builder->where(function ($q) {
                $q->where('order_executions.completed', true)
                    ->where('order_executions.reassigned', false);
            });
        }

        if ($value == 'reassigned') {
            return $this->builder->where(function ($q) {
                $q->where('order_executions.completed', false)
                    ->where('order_executions.reassigned', true);
            });
        }

        return $this->builder;
    }
}

