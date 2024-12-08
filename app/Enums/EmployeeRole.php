<?php

namespace App\Enums;

use App\Enums\Concerns\InteractsWithArrays;

enum EmployeeRole: string
{
    use InteractsWithArrays;

    case ORDERS_FULFILLMENT = 'orders-fulfillment';

    case STOCKTAKING = 'stocktaking';

    /**
     * Methods
     */
    public static function toSelectArray()
    {
        $options = [];

        foreach (self::values() as $value) {
            $options[$value] = __("admin.employees.roles.{$value}");
        }

        return $options;
    }
}
