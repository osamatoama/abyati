<?php

namespace App\Dto\Orders;

final class OrderStatusDto
{
    public function __construct(
        public string  $remoteId,
        public ?string $remoteOriginalId,
        public ?string $remoteParentId,
        public int     $storeId,
        public ?string $name,
        public ?string $type,
        public ?string $slug,
        public ?string $originalName,
        public bool    $active,
    )
    {
    }

    public static function fromSalla(array $sallaOrderStatus, int $storeId): self
    {
        return new self(
            remoteId: $sallaOrderStatus['id'],
            remoteOriginalId: $sallaOrderStatus['original']['id'] ?? null,
            remoteParentId: $sallaOrderStatus['parent']['id'] ?? null,
            storeId: $storeId,
            name: $sallaOrderStatus['name'],
            type: $sallaOrderStatus['type'],
            slug: $sallaOrderStatus['slug'],
            originalName: $sallaOrderStatus['original']['name'] ?? null,
            active: $sallaOrderStatus['is_active'],
        );
    }

    public static function fromSallaOrder(array $sallaOrderStatus, int $storeId): self
    {
        return new self(
            remoteId: $sallaOrderStatus['customized']['id'],
            remoteOriginalId: $sallaOrderStatus['id'] ?? null,
            remoteParentId: null,
            storeId: $storeId,
            name: $sallaOrderStatus['customized']['name'],
            type: null,
            slug: $sallaOrderStatus['slug'],
            originalName: $sallaOrderStatus['name'] ?? null,
            active: true, // TODO:fix
        );
    }

    public static function fromSallaOrderHistory(array $sallaOrderHistoryStatus, int $storeId): self
    {
        return new self(
            remoteId: $sallaOrderHistoryStatus['id'],
            remoteOriginalId: $sallaOrderHistoryStatus['original']['id'] ?? null,
            remoteParentId: $sallaOrderHistoryStatus['parent']['id'] ?? null,
            storeId: $storeId,
            name: $sallaOrderHistoryStatus['name'],
            type: $sallaOrderHistoryStatus['type'],
            slug: $sallaOrderHistoryStatus['slug'],
            originalName: $sallaOrderHistoryStatus['original']['name'] ?? null,
            active: $sallaOrderHistoryStatus['is_active'],
        );
    }
}
