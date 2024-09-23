<?php

namespace App\Services\Orders\Webhooks;

use App\Models\Order;
use App\Dto\Orders\OrderDto;
use App\Dto\Orders\OrderItemDto;
use App\Dto\Products\ProductDto;
use App\Dto\Orders\OrderStatusDto;
use App\Services\Concerns\HasInstance;
use App\Services\Orders\OrderItemService;
use App\Services\Products\ProductService;
use App\Services\Orders\OrderStatusService;

final class UpdateOrderService
{
    use HasInstance;

    public function update(Order $order, OrderDto $orderDto): Order
    {
        $order->update([
            'reference_id' => $orderDto->referenceId,
            'branch_id' => $orderDto->branchId,
            'date' => $orderDto->date,
            'status_id' => $orderDto->statusId,
            'status_name' => $orderDto->statusName,
            'amounts' => $orderDto->amounts,
            'customer' => $orderDto->customer,
        ]);

        return $order;
    }

    public function save(Order $order, array $sallaOrder, int $storeId, string $accessToken): void
    {
        $order = $this->update(
            order: $order,
            orderDto: OrderDto::fromSalla(
                sallaOrder: $sallaOrder,
                storeId: $storeId,
                statusId: OrderStatusService::instance()
                    ->firstOrCreate(
                        orderStatusDto: OrderStatusDto::fromSallaOrder(
                            sallaOrderStatus: $sallaOrder['status'],
                            storeId: $storeId,
                        ),
                    )
                    ->id,
            ),
        );

        foreach ($sallaOrder['items'] as $item) {
            OrderItemService::instance()
                ->updateOrCreate(
                    orderItemDto: OrderItemDto::fromSallaWebhook(
                        sallaOrderItem: $item,
                        orderId: $order->id,
                        productId: ProductService::instance()
                            ->firstOrCreate(
                                productDto: ProductDto::fromSallaOrderItem(
                                    sallaOrderItemProduct: $item['product'],
                                    storeId: $storeId,
                                ),
                            )
                            ->id,
                    ),
                );
        }
    }
}
