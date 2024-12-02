<?php

namespace App\Services\Orders\Tags\Checkers;

use App\Models\Order;
use App\Enums\OrderPaymentMethod;
use App\Services\Orders\Tags\Checkers\Concerns\TagChecker;

class ShouldConfirmBankTransferChecker implements TagChecker
{
    public static function check(Order $order): bool
    {
        logger()->debug($order->payment_method);
        logger()->debug(OrderPaymentMethod::BANK->value);
        logger()->debug($order->payment_method == OrderPaymentMethod::BANK->value);


        return $order->payment_method == OrderPaymentMethod::BANK->value;
    }
}
