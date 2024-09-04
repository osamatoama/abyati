<?php

namespace App\Services\Orders;

use App\Models\Order;
use App\Dto\ProductDto;
use App\Dto\Orders\OrderDto;
use App\Enums\Queues\BatchName;
use App\Dto\Orders\OrderItemDto;
use App\Dto\Orders\OrderStatusDto;
use App\Services\Queues\BatchService;
use App\Services\Concerns\HasInstance;
use App\Services\Products\ProductService;
use App\Jobs\Salla\Pull\OrderHistories\PullOrderHistoriesJob;

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
                    'marketer_id' => $orderDto->marketerId,
                ],
                values: [
                    'coupon_id' => $orderDto->couponId,
                    'date' => $orderDto->date,
                    'date_timezone' => $orderDto->dateTimezone,
                    'status_id' => $orderDto->statusId,
                    'status_name' => $orderDto->statusName,
                    'sub_total' => $orderDto->subTotal,
                    'shipping_cost' => $orderDto->shippingCost,
                    'cash_on_delivery' => $orderDto->cashOnDelivery,
                    'tax' => $orderDto->tax,
                    'discount' => $orderDto->discount,
                    'discounted_shipping' => $orderDto->discountedShipping,
                    'total' => $orderDto->total,
                    'currency' => $orderDto->currency,
                    'commission' => $orderDto->commission,
                    // 'is_payment_due' => $orderDto->isPaymentDue,
                    // 'is_commission_paid' => $orderDto->isCommissionPaid,
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

        foreach ($sallaOrder['items'] as $item) {
            OrderItemService::instance()
                ->updateOrCreate(
                    orderItemDto: OrderItemDto::fromSalla(
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

        (new OrderCommissionCalculator($order))->update();

        BatchService::instance()
            ->createPendingBatch(
                jobs: new PullOrderHistoriesJob(
                    accessToken: $accessToken,
                    storeId: $storeId,
                    orderId: $order->id,
                    orderRemoteId: $order->remote_id,
                    statusChangesOnly: true,
                ),
                batchName: BatchName::SALLA_PULL_ORDER_HISTORIES,
                storeId: $storeId,
            )
            ->dispatch();
    }
}
