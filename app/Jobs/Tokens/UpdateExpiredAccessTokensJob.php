<?php

namespace App\Jobs\Tokens;

use App\Models\Token;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateExpiredAccessTokensJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public bool $force = false,
    )
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Token::query()
            ->when(! $this->force, fn($q) =>
                $q->invalid()
            )
            ->each(
                callback: function (Token $token): void {
                    UpdateExpiredAccessTokenJob::dispatch(
                        token: $token,
                    );
                },
            );
    }
}
