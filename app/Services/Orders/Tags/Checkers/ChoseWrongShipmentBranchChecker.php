<?php

namespace App\Services\Orders\Tags\Checkers;

use App\Models\Order;
use App\Models\Branch;
use App\Services\Orders\Tags\Checkers\Concerns\TagChecker;

class ChoseWrongShipmentBranchChecker implements TagChecker
{
    public static function check(Order $order): bool
    {
        $branches = Branch::query()
            ->forStore($order->store_id)
            ->with([
                'city',
            ])
            ->get();

        $shipmentBranch = $branches->firstWhere('id', $order->shipment_branch_id);
        $shipmentBranchCity = $shipmentBranch->city;
        $addressCity = $order->getAddressCity();

        if ($shipmentBranchCity->id == $addressCity->id) {
            return false;
        }

        return in_array(
            $addressCity->id,
            $branches->where('id', '!=', $order->shipment_branch_id)
                ->pluck('city_id')
                ->toArray(),
        );
    }
}
