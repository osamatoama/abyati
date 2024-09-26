<?php

namespace App\Jobs\Salla\Contracts;

interface WebhookEvent
{
    public function __construct(string $event, int $merchantId, array $data);
}
