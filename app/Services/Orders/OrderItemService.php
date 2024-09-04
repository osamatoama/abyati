<?php

namespace App\Services\Orders;

use App\Dto\Orders\OrderItemDto;
use App\Models\OrderItem;
use App\Services\Concerns\HasInstance;

final class OrderItemService
{
    use HasInstance;

    public function updateOrCreate(OrderItemDto $orderItemDto): OrderItem
    {
        return OrderItem::query()
            ->updateOrCreate(
                attributes: [
                    'remote_id' => $orderItemDto->remoteId,
                    'order_id' => $orderItemDto->orderId,
                ],
                values: [
                    'product_id' => $orderItemDto->productId,
                    'name' => $orderItemDto->name,
                    'quantity' => $orderItemDto->quantity,
                    'total' => $orderItemDto->total,
                    'currency' => $orderItemDto->currency,
                ],
            );
    }
}
