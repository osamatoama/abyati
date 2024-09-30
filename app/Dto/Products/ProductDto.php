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

    public static function fromSallaOrderItemApi(array $sallaOrderItem, int $storeId): self
    {
        $mainImage = null;
        if (filled($sallaOrderItem['product_thumbnail'])) {
            $mainImage = $sallaOrderItem['product_thumbnail'];
        } elseif (filled($sallaOrderItem['thumbnail'])) {
            $mainImage = $sallaOrderItem['thumbnail'];
        }

        return new self(
            storeId: $storeId,
            remoteId: $sallaOrderItem['product_id'],
            name: $sallaOrderItem['name'],
            sku: $sallaOrderItem['sku'],
            mainImage: $mainImage,
        );
    }

    public static function fromSallaOrderItemWebhook(array $sallaOrderItemProduct, int $storeId): self
    {
        return new self(
            storeId: $storeId,
            remoteId: $sallaOrderItemProduct['id'],
            name: $sallaOrderItemProduct['name'],
            sku: $sallaOrderItemProduct['sku'],
            mainImage: $sallaOrderItemProduct['thumbnail'] ?? null,
        );
    }
}
