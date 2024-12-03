<?php

namespace App\Services\Orders\Tags;

use App\Models\Tag;
use App\Models\Order;
use App\Enums\TagSlug;
use App\Services\Orders\Tags\Checkers\IsExternalOrderChecker;
use App\Services\Orders\Tags\Checkers\HasFrozenProductsChecker;
use App\Services\Orders\Tags\Checkers\ChoseWrongShipmentBranchChecker;
use App\Services\Orders\Tags\Checkers\ShouldConfirmBankTransferChecker;

class OrderTagChecker
{
    public static function check(Order $order, Tag $tag): bool
    {
        return match ($tag->slug) {
            TagSlug::HAS_FROZEN_PRODUCTS->value => HasFrozenProductsChecker::check($order),
            TagSlug::CONFIRM_BANK_TRANSFER->value => ShouldConfirmBankTransferChecker::check($order),
            TagSlug::WRONG_SHIPMENT_BRANCH->value => ChoseWrongShipmentBranchChecker::check($order),
            TagSlug::EXTERNAL_ORDER->value => IsExternalOrderChecker::check($order),
            default => false,
        };
    }
}
