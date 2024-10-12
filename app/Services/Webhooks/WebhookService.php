<?php

namespace App\Services\Webhooks;

use App\Models\Webhook;
use App\Dto\Webhooks\WebhookDto;
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
                    'provider_store_id' => $webhookDto->providerStoreId,
                    'event' => $webhookDto->event,
                    'provider_created_at' => $webhookDto->providerCreatedAt,
                    'headers' => $webhookDto->headers,
                    'payload' => $webhookDto->payload,
                ],
            );
    }
}
