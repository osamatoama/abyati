<?php

namespace App\Models;

use App\Enums\OrderCompletionStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderExecutionHistory extends Model
{
    use SoftDeletes;

    /**
     * Config
     */
    protected $fillable = [
        'order_id',
        'employee_id',
        'status',
    ];

    protected $casts = [
        'completion_status' => OrderCompletionStatus::class,
    ];

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
}
