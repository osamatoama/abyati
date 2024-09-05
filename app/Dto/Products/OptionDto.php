<?php

namespace App\Dto\Products;

final class OptionDto
{
    public function __construct(
        public int     $storeId,
        public int     $remoteId,
        public int     $productId,
        public ?string $name,
    )
    {
        //
    }

    public static function fromSalla(array $sallaOption, int $storeId, int $productId): self
    {
        return new self(
            storeId: $storeId,
            productId: $productId,
            remoteId: $sallaOption['id'],
            name: $sallaOption['name'],
        );
    }
}
