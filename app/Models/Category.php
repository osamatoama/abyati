<?php

namespace App\Models;

use App\Models\Concerns\BelongsToUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    use BelongsToUser;

    /**
     * Config
     */
    protected $fillable = [
        'store_id',
        'remote_id',
        'name',
        'image',
        'status',
    ];

    /**
     * Relationships
     */
    public function products()
    {
        return $this->belongsToMany(
            related: Product::class,
            table: 'category_product',
        );
    }
}
