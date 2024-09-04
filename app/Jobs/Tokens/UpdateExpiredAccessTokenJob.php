<?php

namespace App\Jobs\Tokens;

use App\Models\Token;
use Illuminate\Bus\Queueable;
use App\Enums\StoreProviderType;
use App\Services\Salla\SallaException;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Jobs\Concerns\InteractsWithException;
use App\Services\Salla\OAuth\SallaOAuthService;

class UpdateExpiredAccessTokenJob implements ShouldQueue
{
    use Dispatchable, InteractsWithException, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Token $token,
    ) {
        $this->maxAttempts = 5;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        match ($this->token->provider_type) {
            StoreProviderType::SALLA => $this->handleSalla(),
        };
    }

    protected function handleSalla(): void
    {
        try {
            $token = (new SallaOAuthService())->getNewToken(refreshToken: $this->token->refresh_token);
        } catch (SallaException $e) {
            $this->handleException(
                exception: new SallaException(message: "Exception while updating salla access token | Token ID: $this->token->id | Message: {$e->getMessage()}", code: $e->getCode()),
            );

            return;
        }

        $this->token->update(attributes: [
            'access_token' => $token->getToken(),
            'refresh_token' => $token->getRefreshToken(),
            'expired_at' => $token->getExpires(),
        ]);
    }
}
