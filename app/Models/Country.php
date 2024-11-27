<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    /**
     * Config
     */
    protected $table = 'countries';

    protected $fillable = [
        'remote_id',
        'name_ar',
        'name_en',
        'code',
        'mobile_code',
    ];

    /**
     * Relationships
     */
    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
