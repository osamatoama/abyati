<?php

namespace App\Services\Orders\Tags\Checkers\Concerns;

use App\Models\Order;

interface TagChecker
{
    public static function check(Order $order): bool;
}
