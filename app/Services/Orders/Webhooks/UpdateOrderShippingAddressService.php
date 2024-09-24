<?php

namespace App\Services\Orders\Webhooks;

use App\Models\Order;
use App\Dto\Orders\OrderDto;
use App\Dto\Orders\OrderStatusDto;
use App\Services\Concerns\HasInstance;
use App\Events\Order\OrderUpdatedEvent;
use App\Services\Orders\OrderStatusService;

final class UpdateOrderShippingAddressService
{
    use HasInstance;

    public function update(Order $order, OrderDto $orderDto): Order
    {
        $order->update([
            'customer' => $orderDto->customer,
            'shipment_type' => $orderDto->shipmentType,
            'address' => $orderDto->address,
        ]);

        return $order;
    }

    public function handle(Order $order, array $sallaOrder, int $storeId): void
    {
        $order = $this->update(
            order: $order,
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

        event(new OrderUpdatedEvent($order));
    }
}
