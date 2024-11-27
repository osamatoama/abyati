<?php

namespace App\Models;

use App\Models\Concerns\HasJson;
use App\Models\Concerns\Filterable;
use App\Models\Filters\OrderFilter;
use App\Enums\OrderCompletionStatus;
use App\Models\Concerns\BelongsToStore;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Concerns\AssignableToEmployee;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasJson;
    use Filterable;
    use SoftDeletes;
    use BelongsToStore;
    use AssignableToEmployee;

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
        'status_id',
        'status_name',
        'ready_for_processing',
        'completion_status',
        'shipment_type',
        'shipping_company_id',
        'shipment_branch_id',
        'payment_method',
        'amounts',
        'customer',
        'address',
    ];

    protected $casts = [
        'date' => 'datetime',
        'ready_for_processing' => 'boolean',
        'completion_status' => OrderCompletionStatus::class,
        'amounts' => 'array',
        'customer' => 'array',
        'address' => 'array',
    ];

    protected $filter = OrderFilter::class;

    /**
     * Relationships
     */
    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function shippingCompany(): BelongsTo
    {
        return $this->belongsTo(ShippingCompany::class);
    }

    public function shipmentBranch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'shipment_branch_id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(OrderStatus::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function itemsWithTrashed(): HasMany
    {
        return $this->hasMany(OrderItem::class)
            ->withTrashed();
    }

    public function executions(): HasMany
    {
        return $this->hasMany(OrderExecution::class);
    }

    public function executionHistories(): HasMany
    {
        return $this->hasMany(OrderExecutionHistory::class);
    }

    public function tags()
    {
        return $this->belongsToMany(
            related: Tag::class,
            table: 'order_tag',
        );
    }

    /**
     * Scopes
     */
    public function readyForProcessing(Builder $query)
    {
        return $query->where('ready_for_processing', true);
    }

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

    public function scopeBranchMine(Builder $query)
    {
        if (auth('employee')->check()) {
            return $query->where('branch_id', auth('employee')->user()->branch_id);
        }

        if (auth('support')->check()) {
            return $query->where('branch_id', auth('support')->user()->branch_id);
        }

        return $query;
    }

    /**
     * Attributes
     */
    public function customerName(): Attribute
    {
        return Attribute::make(
            get: function() {
                $name = '';
                if (filled($this->customer['first_name'])) {
                    $name .= $this->customer['first_name'] ?? '';
                }

                if (filled($this->customer['last_name'])) {
                    $name .= ' ' . $this->customer['last_name'] ?? '';
                }

                return filled($name) ? $name : null;
            },
        );
    }

    public function customerPhone(): Attribute
    {
        return Attribute::make(
            get: function() {
                $phone = '';
                if (filled($this->customer['mobile_code'])) {
                    $phone .= $this->customer['mobile_code'] ?? '';
                }

                if (filled($this->customer['mobile'])) {
                    $phone .= $this->customer['mobile'] ?? '';
                }

                return filled($phone) ? $phone : null;
            },
        );
    }

    public function total(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->amounts['total']['amount'] ?? null,
        );
    }

    /**
     * TEMP: will be removed when relating order directly to warehouse
     */
    public function warehouseId(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->branch?->warehouse?->id ?? null,
        );
    }

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

    public function isPickup(): bool
    {
        return $this->shipment_type === 'pickup';
    }

    public function isExecuted(): bool
    {
        return $this->items->every(fn(OrderItem $item) => $item->isExecuted());
    }

    public function startedProcessing(): bool
    {
        return ! $this->doesntStartProcessing();
    }

    public function doesntStartProcessing(): bool
    {
        return $this->items->every(fn(OrderItem $item) => $item->isNotExecuted());
    }

    public function setAsPending(): void
    {
        $this->update([
            'completion_status' => OrderCompletionStatus::PENDING,
        ]);
    }

    public function setAsProcessing(): void
    {
        $this->update([
            'completion_status' => OrderCompletionStatus::PROCESSING,
        ]);
    }

    public function setAsQuantityIssues(): void
    {
        $this->update([
            'completion_status' => OrderCompletionStatus::QUANTITY_ISSUES,
        ]);
    }

    public function setAsCompleted(): void
    {
        $this->update([
            'completion_status' => OrderCompletionStatus::COMPLETED,
        ]);
    }

    public function logPendingToHistory($employeeId = null): void
    {
        $this->executionHistories()->create([
            'executor_type' => filled($employeeId) ? Employee::class : null,
            'executor_id' => $employeeId,
            'status' => OrderCompletionStatus::PENDING,
        ]);
    }

    public function logProcessingToHistory($employeeId = null): void
    {
        $this->executionHistories()->create([
            'executor_type' => filled($employeeId) ? Employee::class : null,
            'executor_id' => $employeeId,
            'status' => OrderCompletionStatus::PROCESSING,
        ]);
    }

    public function logQuantityIssuesToHistory($employeeId = null): void
    {
        $this->executionHistories()->create([
            'executor_type' => filled($employeeId) ? Employee::class : null,
            'executor_id' => $employeeId,
            'status' => OrderCompletionStatus::QUANTITY_ISSUES,
        ]);
    }

    public function logCompletedToHistory($executorType = null, $executorId = null): void
    {
        $this->executionHistories()->create([
            'executor_type' => $executorType,
            'executor_id' => $executorId,
            'status' => OrderCompletionStatus::COMPLETED,
        ]);
    }

    public function getItemsSortedByShelf()
    {
        $this->loadMissing([
            'items',
            'items.product',
            'items.product.shelves' => fn($q) => $q->where('warehouse_id', $this->warehouse_id),
        ]);

        $this->items->each(function(OrderItem $item) {
            $shelf = $item->product?->shelves?->first();
            $item->aisle = $shelf?->aisle ?? null;
            $item->shelf = $shelf?->name ?? null;
            // $item->shelf_number = filled($item->shelf) ? str($item->shelf)->after($item->aisle)->__toString() : null;
        });

        return $this->items->sortBy([
            ['aisle', 'asc'],
            // function(OrderItem $item) {
            //     return $item->shelf_number;
            // },
        ]);
    }

    public function getAddressCity(): ?City
    {
        if (empty($this->address['city_id'])) {
            return null;
        }

        return City::find($this->address['city_id']);
    }
}
