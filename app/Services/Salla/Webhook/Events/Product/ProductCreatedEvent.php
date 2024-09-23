<?php

namespace App\Services\Salla\Webhook\Events\Product;

use App\Jobs\Salla\Webhook\Product\ProductCreatedJob;
use App\Services\Salla\Webhook\Contracts\WebhookEvent;

final class ProductCreatedEvent implements WebhookEvent
{
    public function __invoke(string $event, int $merchantId, array $data): void
    {
        logger()->notice("Event: {$event}");
        logger()->notice($data);

        ProductCreatedJob::dispatch(
            event: $event,
            merchantId: $merchantId,
            data: $data,
        );
    }
}
