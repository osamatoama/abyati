<?php

namespace App\Enums;

use App\Enums\Concerns\InteractsWithArrays;

enum SettingType: string
{
    use InteractsWithArrays;

    /**
     * Cases
     */
    case PRODUCTS = 'products';
}
