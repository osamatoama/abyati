<?php

namespace App\Enums;

use App\Enums\Concerns\InteractsWithArrays;

enum StoreProviderType: string
{
    use InteractsWithArrays;

    /**
     * Cases
     */
    case SALLA = 'salla';

    public function label(): string
    {
        return match ($this) {
            self::SALLA => 'Salla',
        };
    }
}
