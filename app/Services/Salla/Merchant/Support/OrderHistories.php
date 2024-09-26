<?php

namespace App\Services\Salla\Merchant\Support;

use App\Services\Salla\Merchant\Client;
use App\Services\Salla\Merchant\Contracts\Support;
use App\Services\Salla\Merchant\SallaMerchantException;
use App\Services\Salla\Merchant\SallaMerchantService;

final class OrderHistories implements Support
{
    public function __construct(
        protected SallaMerchantService $service,
        protected Client $client,
    ) {}

    /**
     * @throws SallaMerchantException
     */
    public function get(int $orderId, int $page = 1): array
    {
        return $this->client->get(
            url: "{$this->service->baseUrl}/orders/{$orderId}/histories",
            query: [
                'page' => $page,
            ],
        );
    }
}
