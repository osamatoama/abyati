<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductShelf extends Pivot
{
    /**
     * Config
     */
    protected $table = 'product_shelf';
}
