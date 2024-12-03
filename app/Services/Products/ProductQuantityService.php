<?php

namespace App\Services\Products;

use App\Models\Product;
use App\Models\ProductQuantity;
use App\Services\Concerns\HasInstance;
use App\Dto\Products\ProductQuantityDto;

final class ProductQuantityService
{
    use HasInstance;

    public function updateOrCreate(ProductQuantityDto $productQuantityDto): ?ProductQuantity
    {
        if (empty($productQuantityDto->branchId)) {
            return null;
        }

        return ProductQuantity::query()
            ->updateOrCreate(
                attributes: [
                    'product_id' => $productQuantityDto->productId,
                    'branch_id' => $productQuantityDto->branchId,
                ],
                values: [
                    'quantity' => $productQuantityDto->quantity,
                ],
            );
    }

    public function saveSallaProductQuantity(Product $product, array $data = []): ?ProductQuantity
    {
        $productQuantity = $this->updateOrCreate(
            productQuantityDto: ProductQuantityDto::fromSalla(
                product: $product,
                data: $data,
            ),
        );

        return $productQuantity;
    }
}
