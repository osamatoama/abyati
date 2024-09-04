<?php

namespace App\Models;

use App\Models\Concerns\BelongsToStore;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Option extends Model
{
    use SoftDeletes;
    use BelongsToStore;

    /**
     * Config
     */
    protected $fillable = [
        'remote_id',
        'store_id',
        'name',
    ];

    /**
     * Relations
     */
    public function values(): HasMany
    {
        return $this->hasMany(OptionValue::class);
    }
}
