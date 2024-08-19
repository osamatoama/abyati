<?php

namespace App\Models;

use App\Models\Concerns\BelongsToStore;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderStatus extends Model
{
    use SoftDeletes;
    use BelongsToStore;

    /**
     * Config
     */
    protected $fillable = [
        'remote_id',
        'remote_original_id',
        'remote_parent_id',
        'store_id',
        'name',
        'type',
        'slug',
        'original_name',
        'active',
    ];

    protected $casts = [
        'id' => 'integer',
        'store_id' => 'integer',
        'active' => 'boolean',
    ];
}
