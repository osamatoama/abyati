<?php

namespace App\Enums;

use App\Enums\Concerns\InteractsWithArrays;

enum OrderPaymentMethod: string
{
    use InteractsWithArrays;

    /**
     * Cases
     */
    case BANK = 'bank';

    case COD = 'cod';

    case WAITING = 'waiting';
}
