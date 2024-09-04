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
        public float   $total,
        public ?string $currency,
    )
    {
    }

    public static function fromSalla(array $sallaOrderItem, int $orderId, int $productId): self
    {
        $total = $sallaOrderItem['amounts']['total']['amount'] ?? 0;
        $fromCurrency = $sallaOrderItem['amounts']['total']['currency'] ?? null;

        return new self(
            remoteId: $sallaOrderItem['id'],
            orderId: $orderId,
            productId: $productId,
            name: $sallaOrderItem['name'] ?? null,
            quantity: $sallaOrderItem['quantity'] ?? 0,
            total: CurrencyConverter::convertToSar($total, $fromCurrency),
            currency: CurrencyConverter::SAR_CODE,
        );
    }
}
