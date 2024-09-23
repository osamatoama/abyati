<?php

namespace App\Dto\Orders;

use App\Models\Product;
use App\Models\OptionValue;
use Illuminate\Support\Arr;
use App\Models\ProductVariant;

final class OrderItemDto
{
    public function __construct(
        public string  $remoteId,
        public int     $orderId,
        public int     $productId,
        public ?int    $variantId = null,
        public ?string $name,
        public int     $quantity,
        public array   $amounts,
    )
    {
        //
    }

    public static function fromSalla(array $sallaOrderItem, int $orderId): self
    {
        $variant = ProductVariant::firstWhere('remote_id', $sallaOrderItem['product_sku_id'] ?? null);

        $productId = $variant?->product_id
            ?? Product::firstWhere('sku', $sallaOrderItem['sku'])?->id;

        return new self(
            remoteId: $sallaOrderItem['id'],
            orderId: $orderId,
            productId: $productId,
            variantId: $variant?->id,
            name: $sallaOrderItem['name'] ?? null,
            quantity: $sallaOrderItem['quantity'] ?? 0,
            amounts: $sallaOrderItem['amounts'] ?? null,
        );
    }

    public static function fromSallaWebhook(array $sallaOrderItem, int $orderId, int $productId): self
    {
        $variantId = null;

        if (isset($sallaOrderItem['options']) and !empty($sallaOrderItem['options'])) {
            $values = Arr::pluck($sallaOrderItem['options'], 'value');
            $optionValueIdsRemoteIds = Arr::pluck($values, 'id');
            $optionValueIds = OptionValue::whereIn('remote_id', $optionValueIdsRemoteIds)
                ->pluck('id')
                ->toArray();

            $variantId = ProductVariant::where('product_id', $productId)
                ->whereHas('optionValues', function ($query) use ($optionValueIds) {
                    $query->whereIn('option_values.id', $optionValueIds);
                }, '=', count($optionValueIds))
                ->first()
                ?->id;
        }

        return new self(
            remoteId: $sallaOrderItem['id'],
            orderId: $orderId,
            productId: $productId,
            variantId: $variantId,
            name: $sallaOrderItem['name'] ?? null,
            quantity: $sallaOrderItem['quantity'] ?? 0,
            amounts: $sallaOrderItem['amounts'] ?? null,
        );
    }
}
