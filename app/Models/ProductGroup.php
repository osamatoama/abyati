<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductGroup extends Model
{
    /**
     * Config
     */
    protected $table = 'product_groups';

    protected $fillable = [
        'group_id',
        'product_id',
        'quantity_in_group',
    ];

    /**
     * Relations
     */
    public function group()
    {
        return $this->belongsTo(Product::class, 'group_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
