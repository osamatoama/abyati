<?php

namespace App\Services\Salla\Webhook\Events\Order;

use App\Services\Salla\Webhook\Contracts\WebhookEvent;
use App\Jobs\Salla\Webhook\Order\OrderShippingAddressUpdatedJob;

final class OrderShippingAddressUpdatedEvent implements WebhookEvent
{
    public function __invoke(string $event, int $merchantId, array $data): void
    {
        logger()->notice("Event: {$event}");
        logger()->notice($data);

        // OrderShippingAddressUpdatedJob::dispatch(
        //     event: $event,
        //     merchantId: $merchantId,
        //     data: $data,
        // );
    }
}