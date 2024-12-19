<?php

namespace App\Dto\Products;

use App\Models\Branch;
use App\Models\Product;

final class ProductQuantityDto
{
    public function __construct(
        public int  $productId,
        public ?int $branchId,
        public ?int $quantity,
        public ?string $expiryDate = null,
    )
    {
        //
    }

    public static function fromSalla(Product $product, array $data = []): self
    {
        $branch = Branch::query()
            ->where('store_id', $product->store_id)
            ->where('remote_id', $data['id'])
            ->first();

        return new self(
            productId: $product->id,
            branchId: $branch?->id,
            quantity: $data['quantity'] ?? null,
            expiryDate: null,
        );
    }
}
