<?php

namespace App\Services\Salla\Merchant\Contracts;

use App\Services\Salla\Merchant\Client;
use App\Services\Salla\Merchant\SallaMerchantService;

interface Support
{
    public function __construct(
        SallaMerchantService $service,
        Client $client,
    );
}
