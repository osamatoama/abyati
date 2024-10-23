<?php

namespace App\Enums;

use App\Enums\Concerns\InteractsWithArrays;

enum ProductStatus: string
{
    use InteractsWithArrays;

    /**
     * Cases
     */
    case SALE = 'sale';

    case OUT = 'out';

    case HIDDEN = 'hidden';

    case DELETED = 'deleted';
}
