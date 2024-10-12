<?php

namespace App\Dto\Webhooks;

use App\Enums\WebhookProviderType;
use Carbon\Carbon;

final class WebhookDto
{
    public function __construct(
        public WebhookProviderType $providerType,
        public ?int $providerStoreId = null,
        public ?string $event = null,
        public ?string $providerCreatedAt = null,
        public array $headers,
        public array $payload,
    ) {}

    public static function fromSalla(array $headers, array $payload): self
    {
        return new self(
            providerType: WebhookProviderType::SALLA,
            providerStoreId: $payload['merchant'] ?? null,
            event: $payload['event'] ?? null,
            providerCreatedAt: filled($payload['created_at']) ? Carbon::parse($payload['created_at']) : null,
            headers: $headers,
            payload: $payload['data'] ?? [],
        );
    }
}
