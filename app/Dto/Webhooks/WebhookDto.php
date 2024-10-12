<?php

namespace App\Dto\Webhooks;

use App\Enums\Providers\WebhookProviderType;

final class WebhookDto
{
    public function __construct(
        public WebhookProviderType $providerType,
        public array $headers,
        public array $payload,
    ) {}

    public static function fromSalla(array $headers, array $payload): self
    {
        return new self(
            providerType: WebhookProviderType::SALLA,
            headers: $headers,
            payload: $payload,
        );
    }
}
