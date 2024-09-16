<?php

namespace App\Models\Concerns;

use App\Models\Employee;
use App\Enums\OrderCompletionStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait AssignableToEmployee
{
    /**
     * Relations
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Scopes
     */
    public function scopeForEmployee(Builder $query, Employee|string|int $employee)
    {
        $employeeId = $employee instanceof Employee ? $employee->id : $employee;

        return $query->where('employee_id', $employeeId);
    }

    public function scopeAssigned(Builder $query)
    {
        return $query->whereNotNull('employee_id');
    }

    public function scopeAssignedTo(Builder $query, string $employeeId)
    {
        return $query->where('employee_id', $employeeId);
    }

    public function scopeNotAssigned(Builder $query)
    {
        return $query->whereNull('employee_id');
    }

    /**
     * Helpers
     */
    public function isAssigned(): bool
    {
        return filled($this->employee_id);
    }

    public function isAssignedTo(string $employeeId): bool
    {
        return $this->employee_id == $employeeId;
    }

    public function isAssignedToMe(): bool
    {
        if (! auth('employee')->check()) {
            return false;
        }

        return $this->employee_id == auth('employee')->id();
    }

    public function isNotAssigned(): bool
    {
        return empty($this->employee_id);
    }

    public function assignTo(string $employeeId): void
    {
        $this->employee_id = $employeeId;
        $this->completion_status = OrderCompletionStatus::PROCESSING;

        $this->save();
    }
}
