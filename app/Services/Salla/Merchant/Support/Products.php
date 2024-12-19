<?php

namespace App\Services\Salla\Merchant\Support;

use App\Services\Salla\Merchant\Client;
use App\Services\Salla\Merchant\Contracts\Support;
use App\Services\Salla\Merchant\SallaMerchantException;
use App\Services\Salla\Merchant\SallaMerchantService;

final class Products implements Support
{
    public function __construct(
        protected SallaMerchantService $service,
        protected Client $client,
    ) {}

    /**
     * @throws SallaMerchantException
     */
    public function get(int $page = 1): array
    {
        return $this->client->get(
            url: "{$this->service->baseUrl}/products",
            query: [
                'page' => $page,
            ],
        );
    }

    /**
     * @throws SallaMerchantException
     */
    public function details(string $id): array
    {
        return $this->client->get(
            url: "{$this->service->baseUrl}/products/{$id}"
        );
    }

    /**
     * @throws SallaMerchantException
     */
    public function restore(int $page = 1): array
    {
        return $this->client->get(
            url: "{$this->service->baseUrl}/products/restore",
            query: [
                'page' => $page,
            ],
        );
    }

    /**
     * @throws SallaMerchantException
     */
    public function quantities(int $page = 1, array $filters = []): array
    {
        return $this->client->get(
            url: "{$this->service->baseUrl}/products/quantities",
            query: array_merge($filters, [
                // 'page' => $page,
            ]),
        );
    }

    /**
     * @throws SallaMerchantException
     */
    public function updateQuantity(string $id, array $data = []): array
    {
        return $this->client->post(
            url: "{$this->service->baseUrl}/products/quantities/bulk",
            data: [
                array_merge($data, [
                    'identifer-type' => 'id',
                    'identifer' => $id,
                    'mode' => 'overwrite',
                ]),
            ],
        );
    }
}
