<?php

namespace App\Dto\ShippingCompanies;

use App\Models\Store;

final class ShippingCompanyDto
{
    public function __construct(
        public int    $remoteId,
        public int    $storeId,
        public string $name,
        public ?string $slug,
    )
    {
        //
    }

    public static function fromSalla(Store $store, array $data): self
    {
        return new self(
            remoteId: $data['id'],
            storeId: $store->id,
            name: $data['name'],
            slug: $data['slug'] ?? null,
        );
    }
}
