<?php

namespace App\Services\ShippingCompanies;

use App\Models\Store;
use App\Models\ShippingCompany;
use App\Services\Concerns\HasInstance;
use App\Dto\ShippingCompanies\ShippingCompanyDto;

final class ShippingCompanyService
{
    use HasInstance;

    public function firstOrCreate(ShippingCompanyDto $shippingCompanyDto): ShippingCompany
    {
        return ShippingCompany::query()
            ->firstOrCreate(
                attributes: [
                    'remote_id' => $shippingCompanyDto->remoteId,
                    'store_id' => $shippingCompanyDto->storeId,
                ],
                values: [
                    'name' => $shippingCompanyDto->name,
                    'slug' => $shippingCompanyDto->slug,
                ],
            );
    }

    public function updateOrCreate(ShippingCompanyDto $shippingCompanyDto): ShippingCompany
    {
        return ShippingCompany::query()
            ->updateOrCreate(
                attributes: [
                    'remote_id' => $shippingCompanyDto->remoteId,
                    'store_id' => $shippingCompanyDto->storeId,
                ],
                values: [
                    'name' => $shippingCompanyDto->name,
                    'slug' => $shippingCompanyDto->slug,
                ],
            );
    }

    public function saveSallaShippingCompany(Store $store, array $data): ShippingCompany
    {
        $shippingCompany = $this->updateOrCreate(
            shippingCompanyDto: ShippingCompanyDto::fromSalla(
                store: $store,
                data: $data,
            ),
        );

        return $shippingCompany;
    }
}
