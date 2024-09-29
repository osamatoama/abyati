<?php

namespace App\Models;

use App\Models\Concerns\HasJson;
use Illuminate\Database\Eloquent\Model;
use App\Enums\OrderItemCompletionStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasJson;
    use SoftDeletes;

    /**
     * Config
     */
    protected $fillable = [
        'remote_id',
        'order_id',
        'product_id',
        'variant_id',
        'name',
        'quantity',
        'executed_quantity',
        'completion_status',
        'amounts',
    ];

    protected $casts = [
        'id' => 'integer',
        'order_id' => 'integer',
        'product_id' => 'integer',
        'variant_id' => 'integer',
        'completion_status' => OrderItemCompletionStatus::class,
        'amounts' => 'array',
    ];


    /**
     * Relationships
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class);
    }

    public function notes(): HasMany
    {
        return $this->hasMany(OrderItemNote::class);
    }

    public function employeeNote()
    {
        return $this->hasOne(OrderItemNote::class)
            ->where('author_type', Employee::class)
            ->latestOfMany();
    }

    /**
     * Attributes
     */
    public function unitPrice(): Attribute
    {
        return Attribute::make(
            get: function() {
                if ($this->quantity === 0) {
                    return 0;
                }

                if (!isset($this->amounts['total']['amount'])) {
                    return 0;
                }

                return $this->amounts['total']['amount'] / $this->quantity;
            },
        );
    }

    public function total(): Attribute
    {
        return Attribute::make(
            get: function() {
                if (!isset($this->amounts['total']['amount'])) {
                    return 0;
                }

                return $this->amounts['total']['amount'];
            },
        );
    }

    /**
     * Scopes
     */
    public function scopePending(Builder $query)
    {
        return $query->where('completion_status', OrderItemCompletionStatus::PENDING);
    }

    public function scopeProcessing(Builder $query)
    {
        return $query->where('completion_status', OrderItemCompletionStatus::PROCESSING);
    }

    public function scopeQuantityIssues(Builder $query)
    {
        return $query->where('completion_status', OrderItemCompletionStatus::QUANTITY_ISSUES);
    }

    public function scopeCompleted(Builder $query)
    {
        return $query->where('completion_status', OrderItemCompletionStatus::COMPLETED);
    }

    /**
     * Helpers
     */
    public function isPending(): bool
    {
        return $this->completion_status === OrderItemCompletionStatus::PENDING;
    }

    public function isProcessing(): bool
    {
        return $this->completion_status === OrderItemCompletionStatus::PROCESSING;
    }

    public function isQuantityIssues(): bool
    {
        return $this->completion_status === OrderItemCompletionStatus::QUANTITY_ISSUES;
    }

    public function isCompleted(): bool
    {
        return $this->completion_status === OrderItemCompletionStatus::COMPLETED;
    }

    public function isExecuted(): bool
    {
        return $this->executed_quantity == $this->quantity;
    }

    public function isNotExecuted(): bool
    {
        return $this->executed_quantity == 0;
    }

    public function isPartiallyExecuted(): bool
    {
        return $this->executed_quantity > 0 && $this->executed_quantity < $this->quantity;
    }

    public function setAsPending(): void
    {
        $this->update([
            'completion_status' => OrderItemCompletionStatus::PENDING,
        ]);
    }

    public function setAsProcessing(): void
    {
        $this->update([
            'completion_status' => OrderItemCompletionStatus::PROCESSING,
        ]);
    }

    public function setAsQuantityIssues(): void
    {
        $this->update([
            'completion_status' => OrderItemCompletionStatus::QUANTITY_ISSUES,
        ]);
    }

    public function setAsCompleted(): void
    {
        $this->update([
            'completion_status' => OrderItemCompletionStatus::COMPLETED,
        ]);
    }
}
