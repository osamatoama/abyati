<?php

namespace App\Enums;

use App\Enums\Concerns\InteractsWithArrays;

enum OrderCompletionStatus: string
{
    use InteractsWithArrays;

    /**
     * Cases
     */
    case PENDING = 'pending';

    case PROCESSING = 'processing';

    case QUANTITY_ISSUES = 'quantity_issues';

    case COMPLETED = 'completed';

    /**
     * Methods
     */
    public function trans()
    {
        return __("admin.orders.completion_statuses.{$this->value}");
    }

    public static function toSelectArray()
    {
        $options = [];

        foreach (self::values() as $value) {
            $options[$value] = __("admin.orders.completion_statuses.{$value}");
        }

        return $options;
    }

    public static function employeeCases()
    {
        return self::cases();
    }

    public static function supportCases()
    {
        return array_filter(
            array: self::cases(),
            callback: fn ($case) => in_array($case->name, ['QUANTITY_ISSUES', 'COMPLETED']),
        );
    }
}
