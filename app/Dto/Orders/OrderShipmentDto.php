<?php

namespace App\Dto\Orders;

final class OrderShipmentDto
{
    public function __construct(
        public ?string $shipmentType,
        public ?array  $address,
    )
    {
        //
    }

    public static function fromSalla(array $sallaShipment): self
    {
        return new self(
            shipmentType: $sallaShipment['type'] ?? null,
            address: $sallaShipment['ship_to'] ?? null,
        );
    }
}
