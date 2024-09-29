<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderExecution extends Model
{
    use SoftDeletes;

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
