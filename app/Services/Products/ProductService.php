<?php

namespace App\Services\Products;

use App\Dto\ProductDto;
use App\Models\Product;
use App\Services\Concerns\HasInstance;

final class ProductService
{
    use HasInstance;

    public function firstOrCreate(ProductDto $productDto): Product
    {
        return Product::query()
            ->firstOrCreate(
                attributes: [
                    'store_id' => $productDto->storeId,
                    'remote_id' => $productDto->remoteId,
                ],
                values: [
                    'name' => $productDto->name,
                    'sku' => $productDto->sku,
                ],
            );
    }

    public function updateOrCreate(ProductDto $productDto): Product
    {
        return Product::query()
            ->updateOrCreate(
                attributes: [
                    'store_id' => $productDto->storeId,
                    'remote_id' => $productDto->remoteId,
                ],
                values: [
                    'name' => $productDto->name,
                    'sku' => $productDto->sku,
                ],
            );
    }

    public function saveSallaProduct(array $sallaProduct, int $storeId): Product
    {
        return $this->updateOrCreate(
            productDto: ProductDto::fromSalla(
                sallaProduct: $sallaProduct,
                storeId: $storeId,
            ),
        );
    }
}
