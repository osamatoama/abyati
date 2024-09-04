<?php

namespace App\Services\Orders;

use App\Dto\Orders\OrderStatusDto;
use App\Models\OrderStatus;
use App\Services\Concerns\HasInstance;

final class OrderStatusService
{
    use HasInstance;

    public function firstOrCreate(OrderStatusDto $orderStatusDto): OrderStatus
    {
        return OrderStatus::query()
            ->firstOrCreate(
                attributes: [
                    'remote_id' => $orderStatusDto->remoteId,
                    'store_id' => $orderStatusDto->storeId,
                ],
                values: [
                    'remote_original_id' => $orderStatusDto->remoteOriginalId,
                    'remote_parent_id' => $orderStatusDto->remoteParentId,
                    'name' => $orderStatusDto->name,
                    'type' => $orderStatusDto->type,
                    'slug' => $orderStatusDto->slug,
                    'original_name' => $orderStatusDto->originalName,
                    'active' => $orderStatusDto->active,
                ],
            );
    }

    public function updateOrCreate(OrderStatusDto $orderStatusDto): OrderStatus
    {
        return OrderStatus::query()
            ->updateOrCreate(
                attributes: [
                    'remote_id' => $orderStatusDto->remoteId,
                    'store_id' => $orderStatusDto->storeId,
                ],
                values: [
                    'remote_original_id' => $orderStatusDto->remoteOriginalId,
                    'remote_parent_id' => $orderStatusDto->remoteParentId,
                    'name' => $orderStatusDto->name,
                    'type' => $orderStatusDto->type,
                    'slug' => $orderStatusDto->slug,
                    'original_name' => $orderStatusDto->originalName,
                    'active' => $orderStatusDto->active,
                ],
            );
    }

    public function saveSallaOrderStatus(array $sallaOrderStatus, int $storeId): OrderStatus
    {
        return $this->updateOrCreate(
            orderStatusDto: OrderStatusDto::fromSalla(
                sallaOrderStatus: $sallaOrderStatus,
                storeId: $storeId,
            ),
        );
    }
}
