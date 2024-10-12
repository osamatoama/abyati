<?php

namespace App\Enums\Providers;

use App\Enums\Concerns\InteractsWithArrays;

enum WebhookProviderType: string
{
    use InteractsWithArrays;

    /**
     * Cases
     */
    case SALLA = 'salla';
}
