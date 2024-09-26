<?php

namespace App\Services\Salla\Webhook\Events;

use App\Services\Salla\Webhook\Contracts\WebhookEvent;

final class UnknownEvent implements WebhookEvent
{
    public function __invoke(string $event, int $merchantId, array $data): void
    {
        $excluded = [
            'app.installed',
        ];

        if (in_array(
            needle: $event,
            haystack: $excluded,
        )) {
            return;
        }

        $json = json_encode(
            value: $data,
            flags: JSON_UNESCAPED_UNICODE,
        );

        logger()->warning(
            message: implode(
                separator: PHP_EOL,
                array: [
                    'Salla unknown webhook event',
                    "Event: {$event}",
                    "MerchantId: {$merchantId}",
                    "Data: {$json}",
                ],
            ),
        );
    }
}
