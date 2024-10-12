<?php

namespace App\Models;

use App\Enums\WebhookProviderType;
use Illuminate\Database\Eloquent\Model;

class Webhook extends Model
{
    /**
     * Config
     */
    protected $fillable = [
        'provider_type',
        'provider_store_id',
        'event',
        'provider_created_at',
        'headers',
        'payload',
    ];

    protected function casts(): array
    {
        return [
            'provider_type' => WebhookProviderType::class,
            'provider_store_id' => 'integer',
            'provider_created_at' => 'datetime',
            'headers' => 'json',
            'payload' => 'json',
        ];
    }
}
