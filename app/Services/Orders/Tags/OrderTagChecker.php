<?php

namespace App\Services\Orders\Tags;

use App\Models\Tag;
use App\Models\Order;
use App\Services\Orders\Tags\Checkers\IsExternalOrderChecker;
use App\Services\Orders\Tags\Checkers\HasFrozenProductsChecker;
use App\Services\Orders\Tags\Checkers\ChoseWrongShipmentBranchChecker;
use App\Services\Orders\Tags\Checkers\ShouldConfirmBankTransferChecker;

class OrderTagChecker
{
    public static function check(Order $order, Tag $tag): bool
    {
        return match ($tag->name) {
            'has_frozen_products' => HasFrozenProductsChecker::check($order),
            'should_confirm_bank_transfer' => ShouldConfirmBankTransferChecker::check($order),
            'chose_wrong_shipment_branch' => ChoseWrongShipmentBranchChecker::check($order),
            'is_external_order' => IsExternalOrderChecker::check($order),
            default => false,
        };
    }
}
