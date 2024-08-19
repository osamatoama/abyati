<?php

namespace App\Models;

use App\Enums\OrderCompletionStatus;
use App\Models\Concerns\BelongsToStore;
use App\Models\Concerns\HasDateFilters;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Concerns\BelongsToEmployee;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use SoftDeletes;
    use BelongsToStore;
    use HasDateFilters;
    use BelongsToEmployee;

    /**
     * Config
     */
    protected $fillable = [
        'remote_id',
        'reference_id',
        'store_id',
        'branch_id',
        'employee_id',
        'date',
        'date_timezone',
        'status_id',
        'status_name',
        'completion_status',
        'shipment_type',
        'amounts',
        'customer',
        'address',
    ];

    protected $casts = [
        'date' => 'datetime',
        'completion_status' => OrderCompletionStatus::class,
        'amounts' => 'array',
        'customer' => 'array',
        'address' => 'array',
    ];

    /**
     * Relationships
     */ 
    public function status(): BelongsTo
    {
        return $this->belongsTo(OrderStatus::class);
    }

    /**
     * Scopes
     */
    public function scopePending(Builder $query)
    {
        return $query->where('completion_status', OrderCompletionStatus::PENDING);
    }

    public function scopeProcessing(Builder $query)
    {
        return $query->where('completion_status', OrderCompletionStatus::PROCESSING);
    }

    public function scopeQuantityIssues(Builder $query)
    {
        return $query->where('completion_status', OrderCompletionStatus::QUANTITY_ISSUES);
    }

    public function scopeCompleted(Builder $query)
    {
        return $query->where('completion_status', OrderCompletionStatus::COMPLETED);
    }


    /**
     * Attributes
     */

    /**
     * Helpers
     */
    public function isPending(): bool
    {
        return $this->completion_status === OrderCompletionStatus::PENDING;
    }

    public function isProcessing(): bool
    {
        return $this->completion_status === OrderCompletionStatus::PROCESSING;
    }

    public function isQuantityIssues(): bool
    {
        return $this->completion_status === OrderCompletionStatus::QUANTITY_ISSUES;
    }

    public function isCompleted(): bool
    {
        return $this->completion_status === OrderCompletionStatus::COMPLETED;
    }
}
