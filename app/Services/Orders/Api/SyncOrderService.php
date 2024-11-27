<?php

namespace App\Services\Orders\Api;

use App\Models\Order;
use App\Dto\Orders\OrderDto;
use App\Dto\Orders\OrderStatusDto;
use Illuminate\Support\Facades\Bus;
use App\Enums\OrderCompletionStatus;
use App\Services\Concerns\HasInstance;
use App\Events\Order\OrderCreatedEvent;
use App\Events\Order\OrderUpdatedEvent;
use App\Services\Orders\OrderStatusService;
use App\Jobs\Salla\Pull\OrderItems\PullOrderItemsJob;
use App\Jobs\Salla\Pull\Shipments\PullFirstOrderShipmentJob;

final class SyncOrderService
{
    use HasInstance;

    public function updateOrCreate(OrderDto $orderDto): Order
    {
        return Order::query()
            ->updateOrCreate(
                attributes: [
                    'remote_id' => $orderDto->remoteId,
                    'store_id' => $orderDto->storeId,
                ],
                values: [
                    'reference_id' => $orderDto->referenceId,
                    'branch_id' => $orderDto->branchId,
                    'date' => $orderDto->date,
                    'status_id' => $orderDto->statusId,
                    'status_name' => $orderDto->statusName,
                    'shipment_type' => $orderDto->shipmentType,
                    'payment_method' => $orderDto->paymentMethod,
                    'amounts' => $orderDto->amounts,
                    'customer' => $orderDto->customer,
                ],
            );
    }

    public function save(array $sallaOrder, int $storeId, string $accessToken): void
    {
        if (!isset($sallaOrder['status']['customized'])) {
            return;
        }

        $order = $this->updateOrCreate(
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

        if (! $order->executionHistories()->exists()) {
            $order->executionHistories()->create([
                'status' => OrderCompletionStatus::PENDING,
            ]);
        }

        $jobs[] = new PullOrderItemsJob(
            accessToken: $accessToken,
            storeId: $storeId,
            data: [
                'order_id' => $order->id,
                'order_remote_id' => $order->remote_id,
            ],
        );

        $jobs[] = new PullFirstOrderShipmentJob(
            accessToken: $accessToken,
            storeId: $storeId,
            data: [
                'order_id' => $order->id,
                'order_remote_id' => $order->remote_id,
            ],
        );

        $jobs[] = function () use ($order) {
            $order->wasRecentlyCreated
                ? event(new OrderCreatedEvent($order))
                : event(new OrderUpdatedEvent($order));
        };

        Bus::chain($jobs)->dispatch();
    }
}
