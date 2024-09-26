<?php

namespace App\Services\Salla\Webhook\Events\App\Store;

use App\Jobs\Salla\Webhook\App\Store\AuthorizeJob;
use App\Services\Salla\Webhook\Contracts\WebhookEvent;

class AppStoreAuthorizeEvent implements WebhookEvent
{
    public function __invoke(string $event, int $merchantId, array $data): void
    {
        $json = json_encode(
            value: $data,
            flags: JSON_UNESCAPED_UNICODE,
        );

        logger()->notice(message: 'Salla app store authorize event'.PHP_EOL."Event: {$event}".PHP_EOL."Merchant: {$merchantId}".PHP_EOL."Data: {$json}");

        AuthorizeJob::dispatch(
            merchantId: $merchantId,
            data: $data,
        );
    }
}
