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

    public function first(ProductDto $productDto): ?Product
    {
        return Product::query()
            ->where('store_id', $productDto->storeId)
            ->where('remote_id', $productDto->remoteId)
            ->first();
    }

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
                    'type' => $productDto->type,
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
                    'type' => $productDto->type,
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

        if ($product->isGroup() && filled($sallaProduct['consisted_products'] ?? [])) {
            $this->saveProductGroupItems(
                product: $product,
                sallaConsistedProducts: $sallaProduct['consisted_products'],
                storeId: $storeId,
            );
        }

        $this->saveProductCategories(
            product: $product,
            sallaProduct: $sallaProduct,
            storeId: $storeId,
        );

        foreach ($sallaProduct['branches_quantities'] ?? [] as $branchQuantity) {
            ProductQuantityService::instance()
                ->saveSallaProductQuantity(
                    product: $product,
                    data: $branchQuantity,
                );
        }

        foreach ($sallaProduct['options'] ?? [] as $option) {
            OptionService::instance()
                ->saveSallaOption(
                    sallaOption: $option,
                    storeId: $storeId,
                    productId: $product->id,
                );
        }

        foreach ($sallaProduct['skus'] ?? [] as $sku) {
            ProductVariantService::instance()
                ->saveSallaProductVariant(
                    sallaSku: $sku,
                    storeId: $storeId,
                    productId: $product->id,
                );
        }

        return $product;
    }

    private function saveProductCategories(Product $product, array $sallaProduct, int $storeId): void
    {
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
    }

    private function saveProductGroupItems(Product $product, array $sallaConsistedProducts, int $storeId)
    {
        $consistedProductsRemoteIds = array_column($sallaConsistedProducts, 'id');

        $existingConsistedProducts = Product::where('store_id', $storeId)
            ->whereIn('remote_id', $consistedProductsRemoteIds)
            ->get();

        $currentConsistedProductRemoteIds = $product->groupItems()
            ->with('product')
            ->get()
            ->pluck('product.remote_id')
            ->toArray();

        $newConsistedProductsRemoteIds = array_diff(
            $consistedProductsRemoteIds,
            $existingConsistedProducts->pluck('remote_id')->toArray(),
        );

        $deletedConsistedProductsRemoteIds = array_diff(
            $currentConsistedProductRemoteIds,
            $consistedProductsRemoteIds,
        );

        $deletedConsistedProducts = filled($deletedConsistedProductsRemoteIds)
            ? Product::whereIn('remote_id', $deletedConsistedProductsRemoteIds)->get()
            : null;

        $sallaConsistedProductsCollection = collect($sallaConsistedProducts);

        foreach ($existingConsistedProducts ?? [] as $consistedProduct) {
            $sallaConsistedProduct = $sallaConsistedProductsCollection
                ->where('id', $consistedProduct->remote_id)
                ->first();

            $product->groupItems()->updateOrCreate([
                'group_id' => $product->id,
                'product_id' => $consistedProduct->id,
            ], [
                'quantity_in_group' => $sallaConsistedProduct['quantity_in_group'] ?? null,
            ]);
        }

        foreach ($newConsistedProductsRemoteIds ?? [] as $newConsistedProductRemoteId) {
            $sallaConsistedProduct = $sallaConsistedProductsCollection
                ->where('id', $newConsistedProductRemoteId)
                ->first();

            $consistedProduct = ProductService::instance()
                ->saveSallaProduct(
                    sallaProduct: $sallaConsistedProduct,
                    storeId: $storeId,
                );

            $product->groupItems()->updateOrCreate([
                'group_id' => $product->id,
                'product_id' => $consistedProduct->id,
            ], [
                'quantity_in_group' => $sallaConsistedProduct['quantity_in_group'] ?? null,
            ]);
        }

        foreach ($deletedConsistedProducts ?? [] as $deletedConsistedProduct) {
            $product->groupItems()->where('product_id', $deletedConsistedProduct->id)->delete();
        }
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
