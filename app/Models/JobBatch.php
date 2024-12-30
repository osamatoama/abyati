<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobBatch extends Model
{
        /**
     * Config
     */
    protected $table = 'job_batches';

    protected $casts = [
        'total_jobs' => 'integer',
        'pending_jobs' => 'integer',
        'failed_jobs' => 'integer',
        'failed_job_ids' => 'array',
        'cancelled_at' => 'datetime',
        'created_at' => 'datetime',
        'finished_at' => 'datetime',
    ];

    public $timestamps = false;

    /**
     * Accessors & Mutators
     */

    /**
     * Scopes
     */

    /**
     * Helpers
     */
    public function cancelled()
    {
        return ! is_null($this->cancelled_at);
    }

    public function finished()
    {
        return ! is_null($this->finished_at);
    }
}
