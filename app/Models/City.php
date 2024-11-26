<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    /**
     * Config
     */
    protected $table = 'cities';

    protected $fillable = [
        'country_id',
        'remote_id',
        'name_ar',
        'name_en',
    ];

    /**
     * Relationships
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
