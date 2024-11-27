<?php

namespace App\Enums;

use App\Enums\Concerns\InteractsWithArrays;

enum TagSlug: string
{
    use InteractsWithArrays;

    /**
     * Cases
     */
    case HAS_FROZEN_PRODUCTS = 'has-frozen-products';

    case CONFIRM_BANK_TRANSFER = 'confirm-bank-transfer';

    case WRONG_SHIPMENT_BRANCH = 'wrong-shipment-branch';

    case EXTERNAL_ORDER = 'external-order';
}
