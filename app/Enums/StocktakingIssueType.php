<?php

namespace App\Enums;

use App\Enums\Concerns\InteractsWithArrays;

enum StocktakingIssueType: string
{
    use InteractsWithArrays;

    /**
     * Cases
     */
    case WRONG_SHELF = 'wrong_shelf';

    case NO_SHELF = 'no_shelf';

    case WRONG_PRICE = 'wrong_price';

    case WRONG_QUANTITY = 'wrong_quantity';

    case WRONG_BARCODE = 'wrong_barcode';

    case MISSING_FROM_SALLA = 'missing_from_salla';

    case OTHER = 'other';

    /**
     * Methods
     */
    public function trans()
    {
        return __("employee.stocktakings.issues.types.{$this->value}");
    }

    public static function toSelectArray()
    {
        $options = [];

        foreach (self::values() as $value) {
            $options[$value] = __("employee.stocktakings.issues.types.{$value}");
        }

        return $options;
    }
}
