<?php

namespace App\Services\Salla\Merchant\Support;

use App\Services\Salla\Merchant\Client;
use App\Services\Salla\Merchant\Contracts\Support;
use App\Services\Salla\Merchant\SallaMerchantException;
use App\Services\Salla\Merchant\SallaMerchantService;

final class Currencies implements Support
{
    public function __construct(
        protected SallaMerchantService $service,
        protected Client $client,
    ) {}

    /**
     * @throws SallaMerchantException
     */
    public function get(): array
    {
        return $this->client->get(
            url: "{$this->service->baseUrl}/currencies"
        );
    }

    /**
     * @throws SallaMerchantException
     */
    public function getAvailable(): array
    {
        return $this->client->get(
            url: "{$this->service->baseUrl}/currencies/available",
        );
    }
}
