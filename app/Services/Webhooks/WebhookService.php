<?php

namespace App\Services\Webhooks;

use App\Dto\WebhookDto;
use App\Models\Webhook;
use App\Services\Concerns\HasInstance;

final class WebhookService
{
    use HasInstance;

    public function create(WebhookDto $webhookDto): Webhook
    {
        return Webhook::query()
            ->create(
                attributes: [
                    'provider_type' => $webhookDto->providerType,
                    'headers' => $webhookDto->headers,
                    'payload' => $webhookDto->payload,
                ],
            );
    }
}
