<?php

namespace App\Enums\Salla;

use App\Enums\Concerns\InteractsWithArrays;

enum OrderAddressType: string
{
    use InteractsWithArrays;

    /**
     * Cases
     */
    case SHIPMENT = 'shipment';

    case PICKUP = 'pickup';
}
