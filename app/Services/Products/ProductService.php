<?php

namespace App\Services\Products;

use App\Models\Product;
use App\Dto\Products\ProductDto;
use App\Services\Concerns\HasInstance;
use App\Services\Products\OptionService;

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
        $product = $this->updateOrCreate(
            productDto: ProductDto::fromSalla(
                sallaProduct: $sallaProduct,
                storeId: $storeId,
            ),
        );

        foreach ($sallaProduct['options'] as $option) {
            OptionService::instance()
                ->saveSallaOption(
                    sallaOption: $option,
                    storeId: $storeId,
                    productId: $product->id,
                );
        }

        foreach ($sallaProduct['skus'] as $sku) {
            ProductVariantService::instance()
                ->saveSallaProductVariant(
                    sallaSku: $sku,
                    storeId: $storeId,
                    productId: $product->id,
                );
        }

        return $product;
    }
}
