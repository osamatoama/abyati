<?php

namespace App\Dto\Branches;

use App\Models\Store;

final class BranchDto
{
    public function __construct(
        public ?int    $remoteId,
        public ?int    $storeId,
        public ?string $name,
        public ?string $remoteName,
        public ?string $type,
        public ?string $status,
        public bool    $isDefault = false,
        public bool    $active = true,
    )
    {
        //
    }

    public static function fromSalla(Store $store, array $data): self
    {
        return new self(
            remoteId: $data['id'],
            storeId: $store->id,
            name: $data['city']['name'] ?? $data['name'],
            remoteName: $data['name'],
            type: $data['type'] ?? null,
            status: $data['status'] ?? null,
            isDefault: $data['is_default'] ?? false,
            active: true,
        );
    }
}