<?php

namespace App\Models;

use App\Models\Concerns\Activatable;
use App\Models\Concerns\BelongsToStore;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Branch extends Model
{
    use BelongsToStore;
    use SoftDeletes;
    use Activatable;

    /**
     * Config
     */
    protected $fillable = [
        'store_id',
        'status_id',
        'name',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    /**
     * Relationships
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(OrderStatus::class);
    }
}
