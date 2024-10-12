<?php

namespace App\Services\Salla\Webhook\Events\Product;

use App\Jobs\Salla\Webhook\Product\ProductUpdatedJob;
use App\Services\Salla\Webhook\Contracts\WebhookEvent;

final class ProductUpdatedEvent implements WebhookEvent
{
    public function __invoke(string $event, int $merchantId, array $data): void
    {
        // logger()->notice("Event: {$event}");
        // logger()->notice($data);

        ProductUpdatedJob::dispatch(
            event: $event,
            merchantId: $merchantId,
            data: $data,
        );
    }
}
