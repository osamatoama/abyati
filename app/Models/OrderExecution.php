<?php

namespace App\Models;

use App\Models\Concerns\Filterable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Filters\OrderExecutionFilter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

class OrderExecution extends Model
{
    use SoftDeletes;
    use Filterable;

    /**
     * Config
     */
    protected $fillable = [
        'order_id',
        'employee_id',
        'completed',
        'reassigned',
        'is_reassign',
        'started_at',
        'completed_at',
        'unassigned_at',
    ];

    protected $casts = [
        'completed' => 'boolean',
        'reassigned' => 'boolean',
        'is_reassign' => 'boolean',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'unassigned_at' => 'datetime',
    ];

    protected $filter = OrderExecutionFilter::class;

    /**
     * Relationships
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Attributes
     */
    public function duration(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (!$this->started_at || !$this->completed_at) {
                    return null;
                }

                return $this->started_at->diffInMinutes($this->completed_at);
            }
        );
    }
}
