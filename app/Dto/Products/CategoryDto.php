<?php

namespace App\Dto\Products;

use App\Models\Store;

final class CategoryDto
{
    public function __construct(
        public int     $storeId,
        public int     $remoteId,
        public ?string $name,
        public ?string $image,
        public ?string $status,
    )
    {
        //
    }

    public static function fromSalla(Store $store, array $data): self
    {
        return new self(
            storeId: $store->id,
            remoteId: $data['id'],
            name: $data['name'],
            image: $data['image'] ?? null,
            status: $data['status'],
        );
    }
}
