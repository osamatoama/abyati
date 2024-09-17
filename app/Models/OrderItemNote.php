<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItemNote extends Model
{
    /**
     * Config
     */
    protected $fillable = [
        'order_item_id',
        'author_id',
        'author_type',
        'content',
    ];

    /**
     * Relationships
     */
    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function author()
    {
        return $this->morphTo();
    }
}
