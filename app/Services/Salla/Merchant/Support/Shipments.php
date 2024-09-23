<?php

namespace App\Services\Salla\Merchant\Support;

use App\Services\Salla\Merchant\Client;
use App\Services\Salla\Merchant\Contracts\Support;
use App\Services\Salla\Merchant\SallaMerchantService;
use App\Services\Salla\Merchant\SallaMerchantException;

final class Shipments implements Support
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
            url: "{$this->service->baseUrl}/shipments",
            query: array_merge(
                [
                    'page' => $page,
                ],
                $filters
            ),
        );
    }

    /**
     * @throws SallaMerchantException
     */
    public function details(string $id, array $filters = []): array
    {
        return $this->client->get(
            url: "{$this->service->baseUrl}/shipments/{$id}",
            query: $filters,
        );
    }
}
