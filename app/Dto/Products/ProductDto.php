<?php

namespace App\Dto\Products;

final class ProductDto
{
    public function __construct(
        public int     $storeId,
        public int     $remoteId,
        public string  $name,
        public ?string $sku,
    )
    {
    }

    public static function fromSalla(array $sallaProduct, int $storeId): self
    {
        return new self(
            storeId: $storeId,
            remoteId: $sallaProduct['id'],
            name: $sallaProduct['name'],
            sku: !empty($sallaProduct['sku']) ? $sallaProduct['sku'] : null,
        );
    }

    public static function fromSallaOrderItem(array $sallaOrderItemProduct, int $storeId): self
    {
        return new self(
            storeId: $storeId,
            remoteId: $sallaOrderItemProduct['id'],
            name: $sallaOrderItemProduct['name'],
            sku: $sallaOrderItemProduct['sku'],
        );
    }
}
