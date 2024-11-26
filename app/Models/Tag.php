<?php

namespace App\Models;

use App\Models\Concerns\Activatable;
use App\Models\Concerns\BelongsToStore;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use SoftDeletes;
    use Activatable;
    use BelongsToStore;

    /**
     * Config
     */
    protected $fillable = [
        'store_id',
        'remote_id',
        'name',
        'slug',
        'description',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    /**
     * Relationships
     */
    public function orders()
    {
        return $this->belongsToMany(
            related: Order::class,
            table: 'order_tag',
        );
    }
}
