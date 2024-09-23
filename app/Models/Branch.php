<?php

namespace App\Models;

use App\Models\Concerns\Activatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Branch extends Model
{
    use SoftDeletes;
    use Activatable;

    /**
     * Config
     */
    protected $fillable = [
        'name',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    /**
     * Relationships
     */
    public function orderStatuses(): BelongsToMany
    {
        return $this->belongsToMany(
                related: OrderStatus::class,
                table: 'branch_order_statuses',
                foreignPivotKey: 'branch_id',
                relatedPivotKey: 'order_status_id',
            )
            ->withPivot('store_id');
    }

    public function stores(): BelongsToMany
    {
        return $this->belongsToMany(
                related: Store::class,
                table: 'branch_order_statuses',
                foreignPivotKey: 'branch_id',
                relatedPivotKey: 'store_id',
            )
            ->withPivot('order_status_id');
    }
}
