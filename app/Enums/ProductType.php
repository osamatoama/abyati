<?php

namespace App\Enums;

use App\Enums\Concerns\InteractsWithArrays;

enum ProductType: string
{
    use InteractsWithArrays;

    /**
     * Cases
     */
    case PRODUCT = 'product';

    case SERVICE = 'service';

    case GROUP_PRODUCTS = 'group_products';

    case CODES = 'codes';

    case DIGITAL = 'digital';

    case FOOD = 'food';

    case DONATING = 'donating';

    case BOOKING = 'booking';
}
