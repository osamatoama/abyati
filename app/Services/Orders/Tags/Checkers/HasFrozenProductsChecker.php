<?php

namespace App\Services\Orders\Tags\Checkers;

use App\Models\Order;
use App\Enums\SettingType;
use App\Services\Orders\Tags\Checkers\Concerns\TagChecker;

class HasFrozenProductsChecker implements TagChecker
{
    public static function check(Order $order): bool
    {
        $frozenProductCategorySettings = settings()
            ->where('store_id', $order->store_id)
            ->where('type', SettingType::PRODUCTS->value)
            ->where('key', 'frozen_product_categories')
            ->first();

        if (empty($frozenProductCategorySettings)) {
            return false;
        }

        $frozenProductCategoryIds = json_decode($frozenProductCategorySettings->value, true);

        $order->load([
            'items.product.categories',
        ]);

        foreach ($order->items as $item) {
            if ($item->product->categories->pluck('id')->intersect($frozenProductCategoryIds)->isNotEmpty()) {
                return true;
            }
        }

        return false;
    }
}
