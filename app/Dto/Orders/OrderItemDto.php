<?php

namespace App\Dto\Orders;

use App\Services\Currencies\CurrencyConverter;

final class OrderItemDto
{
    public function __construct(
        public string  $remoteId,
        public int     $orderId,
        public int     $productId,
        public ?string $name,
        public int     $quantity,
        public array   $amounts,
    )
    {
        //
    }

    public static function fromSalla(array $sallaOrderItem, int $orderId, int $productId): self
    {
        return new self(
            remoteId: $sallaOrderItem['id'],
            orderId: $orderId,
            productId: $productId,
            name: $sallaOrderItem['name'] ?? null,
            quantity: $sallaOrderItem['quantity'] ?? 0,
            amounts: $sallaOrderItem['amounts'] ?? null,
        );
    }
}
