<?php

namespace App\Services\Orders;

use App\Models\Order;
use App\Dto\Orders\OrderDto;
use App\Dto\Orders\OrderItemDto;
use App\Dto\Products\ProductDto;
use App\Dto\Orders\OrderStatusDto;
use App\Dto\Orders\OrderShipmentDto;
use App\Enums\OrderCompletionStatus;
use App\Services\Concerns\HasInstance;
use App\Services\Products\ProductService;
use App\Jobs\Salla\Pull\OrderItems\PullOrderItemsJob;
use App\Jobs\Salla\Pull\Shipments\PullFirstOrderShipmentJob;

// use App\Enums\Queues\BatchName;
// use App\Services\Queues\BatchService;
// use App\Jobs\Salla\Pull\OrderHistories\PullOrderHistoriesJob;

final class OrderService
{
    use HasInstance;

    public function updateOrCreate(OrderDto $orderDto): Order
    {
        return Order::query()
            ->updateOrCreate(
                attributes: [
                    'remote_id' => $orderDto->remoteId,
                    'reference_id' => $orderDto->referenceId,
                    'store_id' => $orderDto->storeId,
                ],
                values: [
                    'branch_id' => $orderDto->branchId,
                    'date' => $orderDto->date,
                    'status_id' => $orderDto->statusId,
                    'status_name' => $orderDto->statusName,
                    'shipment_type' => $orderDto->shipmentType,
                    'payment_method' => $orderDto->paymentMethod,
                    'amounts' => $orderDto->amounts,
                    'customer' => $orderDto->customer,
                    'address' => $orderDto->address,
                ],
            );
    }

    public function saveSallaOrder(array $sallaOrder, int $storeId, string $accessToken): void
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

        dispatch(new PullOrderItemsJob(
            accessToken: $accessToken,
            storeId: $storeId,
            order: $order,
            data: [
                'order_id' => $order->id,
                'order_remote_id' => $order->remote_id,
            ],
        ));

        dispatch(new PullFirstOrderShipmentJob(
            accessToken: $accessToken,
            storeId: $storeId,
            data: [
                'order_id' => $order->id,
                'order_remote_id' => $order->remote_id,
            ],
        ));

        // BatchService::instance()
        //     ->createPendingBatch(
        //         jobs: new PullOrderHistoriesJob(
        //             accessToken: $accessToken,
        //             storeId: $storeId,
        //             orderId: $order->id,
        //             orderRemoteId: $order->remote_id,
        //             statusChangesOnly: true,
        //         ),
        //         batchName: BatchName::SALLA_PULL_ORDER_HISTORIES,
        //         storeId: $storeId,
        //     )
        //     ->dispatch();
    }

    public function saveSallaOrderFromWebhook(array $sallaOrder, int $storeId, string $accessToken): void
    {
        if (!isset($sallaOrder['status']['customized'])) {
            return;
        }

        $order = $this->updateOrCreate(
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

        if (! $order->executionHistories()->exists()) {
            $order->executionHistories()->create([
                'status' => OrderCompletionStatus::PENDING,
            ]);
        }

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

        // BatchService::instance()
        //     ->createPendingBatch(
        //         jobs: new PullOrderHistoriesJob(
        //             accessToken: $accessToken,
        //             storeId: $storeId,
        //             orderId: $order->id,
        //             orderRemoteId: $order->remote_id,
        //             statusChangesOnly: true,
        //         ),
        //         batchName: BatchName::SALLA_PULL_ORDER_HISTORIES,
        //         storeId: $storeId,
        //     )
        //     ->dispatch();
    }

    public function saveShipment(string $orderId, array $shipment)
    {
        $order = Order::find($orderId);

        if ($order === null) {
            return;
        }

        $shipmentDto = OrderShipmentDto::fromSalla($shipment);

        $order->update([
            'shipment_type' => $shipmentDto->shipmentType,
            'shipping_company_id' => $shipmentDto->shippingCompanyId,
            // 'shipment_branch_id' => $shipmentDto->shipmentBranchId,
            'address' => $shipmentDto->address,
        ]);
    }
}
