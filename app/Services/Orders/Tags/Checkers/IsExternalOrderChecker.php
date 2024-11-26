<?php

namespace App\Services\Orders\Tags\Checkers;

use App\Models\Order;
use App\Services\Orders\Tags\Checkers\Concerns\TagChecker;

class IsExternalOrderChecker implements TagChecker
{
    public static function check(Order $order): bool
    {
        $shipmentBranch = $order->shipmentBranch;
        $shipmentBranchCity = $shipmentBranch->city;
        $addressCity = $order->getAddressCity();

        return $shipmentBranchCity->id != $addressCity->id;
    }
}
