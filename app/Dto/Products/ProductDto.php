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
        public ?string $status = null,
        public ?int    $quantity = null,
        public bool    $unlimitedQuantity = false,
        public ?float  $price = null,
        public ?float  $salePrice = null,
        public ?float  $regularPrice = null,
        public ?string $currency = null,
    )
    {
        //
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
            status: $sallaProduct['status'] ?? null,
            quantity: $sallaProduct['quantity'] ?? null,
            unlimitedQuantity: $sallaProduct['unlimited_quantity'] ?? false,
            price: $sallaProduct['price']['amount'] ?? null,
            salePrice: $sallaProduct['sale_price']['amount'] ?? null,
            regularPrice: $sallaProduct['regular_price']['amount'] ?? null,
            currency: $sallaProduct['price']['currency'] ?? null,
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
            status: null,
            quantity: null,
            unlimitedQuantity: false,
            price: null,
            salePrice: null,
            regularPrice: null,
            currency: null,
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
            // status: $sallaOrderItemProduct['status'] ?? null,
            status: null,
            quantity: null,
            unlimitedQuantity: false,
            price: $sallaOrderItemProduct['price']['amount'] ?? null,
            salePrice: $sallaOrderItemProduct['sale_price']['amount'] ?? null,
            regularPrice: $sallaOrderItemProduct['regular_price']['amount'] ?? null,
            currency: $sallaOrderItemProduct['price']['currency'] ?? null,
        );
    }
}
