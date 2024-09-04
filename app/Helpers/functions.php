<?php

use Illuminate\Support\Number;

if (! function_exists('formatCurrency')) {
    function formatCurrency($amount, $currency = 'SAR')
    {
        $formattedAmount = number_format(
            num: $amount,
            decimals: (is_numeric($amount) && $amount == floor($amount)) ? 0 : 2
        );
        $currencySymbol = str(Number::currency(1, $currency, app()->getLocale()))
            ->before('1.00')
            ->after('١٫٠٠')
            ->trim();

        return $formattedAmount . ' ' . $currencySymbol;
    }
}

if (! function_exists('formatPercentage')) {
    function formatPercentage($amount)
    {
        $formattedAmount = number_format(
            num: $amount,
            decimals: (is_numeric($amount) && $amount == floor($amount)) ? 0 : 2
        );

        return $formattedAmount . '%';
    }
}

if (! function_exists('boolToYesNo')) {
    function boolToYesNo(mixed $value, bool $translate = true): string
    {
        $value = (bool) $value;

        if ($translate) {
            return $value ? __('globals.yes') : __('globals.no');
        }

        return $value ? 'yes' : 'no';
    }
}

