<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FailedJob extends Model
{
    /**
     * Config
     */
    protected $table = 'failed_jobs';

    protected $casts = [
        'payload' => 'object',
        'failed_at' => 'datetime',
    ];

    protected $fillable = ['queue'];

    public $timestamps = false;

    /**
     * Accessors & Mutators
     */
    public function getDisplayNameAttribute()
    {
        return $this->payload->displayName;
    }

    /**
     * Scopes
     */
    public function scopeForClass($query, $class)
    {
        $query->where('payload->displayName', $class);
    }

    /**
     * Helpers
     */
    public function classExists()
    {
        return class_exists($this->display_name);
    }

    public function getArguments()
    {
        $args = null;

        if ($this->classExists()) {
            $args = unserialize($this->payload->data->command);
        }

        return $args;
    }
}
