<?php

namespace App\Services\Salla\Webhook\Events\Order;

use App\Jobs\Salla\Webhook\Order\OrderCreatedJob;
use App\Services\Salla\Webhook\Contracts\WebhookEvent;

final class OrderCreatedEvent implements WebhookEvent
{
    public function __invoke(string $event, int $merchantId, array $data): void
    {
        logger()->notice("Event: {$event}");
        logger()->notice($data);

        OrderCreatedJob::dispatch(
            event: $event,
            merchantId: $merchantId,
            data: $data,
        );
    }
}
