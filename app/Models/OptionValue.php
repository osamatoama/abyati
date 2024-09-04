<?php

namespace App\Models;

use App\Models\Concerns\BelongsToStore;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OptionValue extends Model
{
    use SoftDeletes;
    use BelongsToStore;


    /**
     * Config
     */
    protected $fillable = [
        'remote_id',
        'store_id',
        'option_id',
        'name',
    ];


    /**
     * Relations
     */
    public function option(): BelongsTo
    {
        return $this->belongsTo(Option::class);
    }
}
