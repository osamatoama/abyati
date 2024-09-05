<?php

namespace App\Services\Products;

use App\Models\ProductVariant;
use App\Services\Concerns\HasInstance;
use App\Dto\Products\ProductVariantDto;

final class ProductVariantService
{
    use HasInstance;

    public function updateOrCreate(ProductVariantDto $productVariantDto): ProductVariant
    {
        return ProductVariant::query()
            ->updateOrCreate(
                attributes: [
                    'store_id' => $productVariantDto->storeId,
                    'remote_id' => $productVariantDto->remoteId,
                ],
                values: [
                    'product_id' => $productVariantDto->productId,
                    'sku' => $productVariantDto->sku,
                    'barcode' => $productVariantDto->barcode,
                    'stock_quantity' => $productVariantDto->stockQuantity,
                    'unlimited_quantity' => $productVariantDto->unlimitedQuantity,
                ],
            );
    }

    public function saveSallaProductVariant(array $sallaSku, int $storeId, int $productId): ProductVariant
    {
        $productVariantDto = ProductVariantDto::fromSalla(
            sallaSku: $sallaSku,
            storeId: $storeId,
            productId: $productId,
        );

        $productVariant = $this->updateOrCreate(
            productVariantDto: $productVariantDto,
        );

        $productVariant->optionValues()->sync($productVariantDto->optionValueIds);

        return $productVariant;
    }
}
