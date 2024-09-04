<?php

namespace App\Services\Salla\Webhook\Contracts;

interface WebhookEvent
{
    public function __invoke(string $event, int $merchantId, array $data): void;
}
