<?php

namespace App\Enums\Concerns;

trait InteractsWithArrays
{
    public static function names(): array
    {
        return array_column(
            array: self::cases(),
            column_key: 'name',
        );
    }

    public static function values(): array
    {
        return array_column(
            array: self::cases(),
            column_key: 'value',
        );
    }

    public static function array(): array
    {
        return array_combine(
            keys: self::names(),
            values: self::values(),
        );
    }

    public static function toValidationRule(): string
    {
        return 'in:' . implode(',', self::values());
    }
}
