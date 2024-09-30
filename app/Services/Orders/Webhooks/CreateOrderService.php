<?php

namespace App\Services\Orders\Webhooks;

use App\Models\Order;
use App\Dto\Orders\OrderDto;
use App\Dto\Orders\OrderItemDto;
use App\Dto\Products\ProductDto;
use App\Dto\Orders\OrderStatusDto;
use App\Enums\OrderCompletionStatus;
use App\Events\Order\OrderCreatedEvent;
use App\Services\Concerns\HasInstance;
use App\Services\Orders\OrderItemService;
use App\Services\Products\ProductService;
use App\Services\Orders\OrderStatusService;

final class CreateOrderService
{
    use HasInstance;

    public function create(OrderDto $orderDto): Order
    {
        return Order::create([
            'remote_id' => $orderDto->remoteId,
            'reference_id' => $orderDto->referenceId,
            'store_id' => $orderDto->storeId,
            'branch_id' => $orderDto->branchId,
            'date' => $orderDto->date,
            'status_id' => $orderDto->statusId,
            'status_name' => $orderDto->statusName,
            'amounts' => $orderDto->amounts,
            'customer' => $orderDto->customer,
            'shipment_type' => $orderDto->shipmentType,
            'address' => $orderDto->address,
        ]);
    }

    public function handle(array $sallaOrder, int $storeId, string $accessToken): void
    {
        logger()->notice("CreateOrderService@handle");

        if (!isset($sallaOrder['status']['customized'])) {
            return;
        }

        $order = $this->create(
            orderDto: OrderDto::fromSallaWebhook(
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

        $order->executionHistories()->create([
            'status' => OrderCompletionStatus::PENDING,
        ]);

        foreach ($sallaOrder['items'] as $item) {
            OrderItemService::instance()
                ->updateOrCreate(
                    orderItemDto: OrderItemDto::fromSallaWebhook(
                        sallaOrderItem: $item,
                        orderId: $order->id,
                        productId: ProductService::instance()
                            ->firstOrCreate(
                                productDto: ProductDto::fromSallaOrderItemWebhook(
                                    sallaOrderItemProduct: $item['product'],
                                    storeId: $storeId,
                                ),
                            )
                            ->id,
                    ),
                );
        }

        // event(new OrderCreatedEvent($order));
    }
}
