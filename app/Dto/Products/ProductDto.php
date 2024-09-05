<?php

namespace App\Dto\Products;

final class ProductDto
{
    public function __construct(
        public int     $storeId,
        public int     $remoteId,
        public string  $name,
        public ?string $sku,
        public ?string $mainImage = null,
    )
    {
    }

    public static function fromSalla(array $sallaProduct, int $storeId): self
    {
        $mainImage = $sallaProduct['main_image']
            ?? collect($sallaProduct['images'])->firstWhere('main', true)['url']
            ?? null;

        return new self(
            storeId: $storeId,
            remoteId: $sallaProduct['id'],
            name: $sallaProduct['name'],
            sku: !empty($sallaProduct['sku']) ? $sallaProduct['sku'] : null,
            mainImage: $mainImage,
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
