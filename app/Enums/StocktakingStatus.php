<?php

namespace App\Enums;

use App\Enums\Concerns\InteractsWithArrays;

enum StocktakingStatus: string
{
    use InteractsWithArrays;

    /**
     * Cases
     */
    case PENDING = 'pending';

    case COMPLETED = 'completed';

    /**
     * Methods
     */
    public function trans()
    {
        return __("employee.stocktakings.statuses.{$this->value}");
    }

    public static function toSelectArray()
    {
        $options = [];

        foreach (self::values() as $value) {
            $options[$value] = __("employee.stocktakings.statuses.{$value}");
        }

        return $options;
    }
}
