<?php

namespace App\Services\Orders\Tags\Checkers;

use App\Models\Order;
use App\Enums\OrderPaymentMethod;
use App\Services\Orders\Tags\Checkers\Concerns\TagChecker;

class ShouldConfirmBankTransferChecker implements TagChecker
{
    public static function check(Order $order): bool
    {
        return $order->payment_method == OrderPaymentMethod::BANK->value;
    }
}
