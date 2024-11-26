<?php

namespace App\Services\Salla\Merchant\Support;

use App\Services\Salla\Merchant\Client;
use App\Services\Salla\Merchant\Enums\OrdersSort;
use App\Services\Salla\Merchant\Contracts\Support;
use App\Services\Salla\Merchant\SallaMerchantService;
use App\Services\Salla\Merchant\SallaMerchantException;

final class Orders implements Support
{
    public function __construct(
        protected SallaMerchantService $service,
        protected Client $client,
    ) {}

    /**
     * @throws SallaMerchantException
     */
    public function get(int $page = 1, OrdersSort $sort = OrdersSort::CREATED_AT_ASC, array $filters = []): array
    {
        return $this->client->get(
            url: "{$this->service->baseUrl}/orders",
            query: array_merge(
                [
                    'page' => $page,
                    'sort_by' => $sort->value,
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
            url: "{$this->service->baseUrl}/orders/{$id}",
            query: $filters,
        );
    }

    /**
     * @throws SallaMerchantException
     */
    public function updateStatus(string $id, array $data = []): array
    {
        return $this->client->post(
            url: "{$this->service->baseUrl}/orders/{$id}/status",
            data: $data,
        );
    }

    /**
     * @throws SallaMerchantException
     */
    public function createTag(string $id, array $data = []): array
    {
        return $this->client->post(
            url: "{$this->service->baseUrl}/orders/{$id}/tags",
            data: $data,
        );
    }
}
