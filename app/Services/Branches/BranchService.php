<?php

namespace App\Services\Branches;

use App\Models\Store;
use App\Models\Branch;
use App\Dto\Branches\BranchDto;
use App\Services\Concerns\HasInstance;

final class BranchService
{
    use HasInstance;

    public function firstOrCreate(BranchDto $branchDto): Branch
    {
        return Branch::query()
            ->firstOrCreate(
                attributes: [
                    'name' => $branchDto->name,
                ],
                values: [
                    'remote_id' => $branchDto->remoteId,
                    'type' => $branchDto->type,
                    'status' => $branchDto->status,
                    'is_default' => $branchDto->isDefault,
                    'active' => $branchDto->active,
                ],
            );
    }

    public function updateOrCreate(BranchDto $branchDto): Branch
    {
        return Branch::query()
            ->firstOrCreate(
                attributes: [
                    'name' => $branchDto->name,
                ],
                values: [
                    'remote_id' => $branchDto->remoteId,
                    'type' => $branchDto->type,
                    'status' => $branchDto->status,
                    'is_default' => $branchDto->isDefault,
                    'active' => $branchDto->active,
                ],
            );
    }

    public function saveSallaBranch(Store $store, array $data): Branch
    {
        $branch = $this->updateOrCreate(
            branchDto: BranchDto::fromSalla(
                store: $store,
                data: $data,
            ),
        );

        return $branch;
    }
}
