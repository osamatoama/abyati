<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use SoftDeletes;

    /**
     * Config
     */
    protected $fillable = [
        'remote_id',
        'store_id',
        'name',
        'sku',
        'barcode',
    ];

    protected $casts = [
        'id' => 'integer',
        'store_id' => 'integer',
    ];

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }
}
