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
        'headers',
        'payload',
    ];

    protected function casts(): array
    {
        return [
            'provider_type' => WebhookProviderType::class,
            'headers' => 'json',
            'payload' => 'json',
        ];
    }
}
