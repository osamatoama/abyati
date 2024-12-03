<?php

namespace App\Enums;

use App\Enums\Concerns\InteractsWithArrays;

enum SettingSource: string
{
    use InteractsWithArrays;

    /**
     * Cases
     */
    case SYSTEM = 'system';

    case SALLA = 'salla';
}
