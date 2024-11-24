<?php

namespace App\Services\Products;

use App\Models\Store;
use App\Models\Product;
use App\Enums\ProductStatus;
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
                    'main_image' => $productDto->mainImage,
                    'status' => $productDto->status,
                    'quantity' => $productDto->quantity,
                    'unlimited_quantity' => $productDto->unlimitedQuantity,
                    'price' => $productDto->price,
                    'sale_price' => $productDto->salePrice,
                    'regular_price' => $productDto->regularPrice,
                    'currency' => $productDto->currency,
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
                    'main_image' => $productDto->mainImage,
                    'status' => $productDto->status,
                    'quantity' => $productDto->quantity,
                    'unlimited_quantity' => $productDto->unlimitedQuantity,
                    'price' => $productDto->price,
                    'sale_price' => $productDto->salePrice,
                    'regular_price' => $productDto->regularPrice,
                    'currency' => $productDto->currency,
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

        $existingCategoryRemoteIds = $product->categories->pluck('remote_id')->toArray();

        $newCategories = array_filter(
            $sallaProduct['categories'],
            fn ($category) => !in_array($category['id'], $existingCategoryRemoteIds),
        );

        $deletedRemoteIds = array_diff($existingCategoryRemoteIds, array_column($sallaProduct['categories'], 'id'));

        if (filled($newCategories)) {
            $newCategoryIds = collect([]);

            foreach ($newCategories as $category) {
                $newCategoryIds->push(
                    CategoryService::instance()
                        ->saveSallaCategory(
                            store: Store::find($storeId),
                            data: $category,
                        )
                        ->id,
                );
            }

            $product->categories()->syncWithoutDetaching($newCategoryIds);
        }

        if (filled($deletedRemoteIds)) {
            $product->categories()->detach($deletedRemoteIds);
        }

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

    public function setStatusDeleted(array $sallaDeletedProduct, int $storeId): ?Product
    {
        $product = Product::where('store_id', $storeId)
            ->where('remote_id', $sallaDeletedProduct['id'])
            ->first();

        if ($product === null) {
            return null;
        }

        $product->update([
            'status' => ProductStatus::DELETED,
        ]);

        return $product;
    }
}
