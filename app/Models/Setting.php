<?php

namespace App\Models;

use App\Enums\SettingType;
use App\Enums\SettingSource;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\BelongsToStore;

class Setting extends Model
{
    use BelongsToStore;

    /**
     * Config
     */
    protected $fillable = [
        'user_id',
        'source',
        'type',
        'key',
        'value',
    ];

    /**
     * Scopes
     */
    public function scopeForProducts($query)
    {
        $query->where('type', SettingType::PRODUCTS->value);
    }

    public function scopeSalla($query)
    {
        $query->where('source', SettingSource::SALLA->value);
    }

    public function scopeSystem($query)
    {
        $query->where('source', SettingSource::SYSTEM->value);
    }
}
