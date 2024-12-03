<?php

namespace App\Services\Salla\Merchant\Support;

use App\Services\Salla\Merchant\Client;
use App\Services\Salla\Merchant\Contracts\Support;
use App\Services\Salla\Merchant\SallaMerchantService;
use App\Services\Salla\Merchant\SallaMerchantException;

final class ShippingCompanies implements Support
{
    public function __construct(
        protected SallaMerchantService $service,
        protected Client $client,
    ) {}

    /**
     * @throws SallaMerchantException
     */
    public function get(int $page = 1, array $filters = []): array
    {
        return $this->client->get(
            url: "{$this->service->baseUrl}/shipping/companies",
            query: array_merge(
                [
                    'page' => $page,
                ],
                $filters
            ),
        );
    }
}
