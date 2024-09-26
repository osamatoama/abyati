<?php

namespace App\Console\Commands\Stores;

use Illuminate\Console\Command;
use App\Jobs\Tokens\UpdateExpiredAccessTokensJob;

class UpdateExpiredTokens extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-expired-tokens {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Salla expired access tokens.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $force = $this->option('force');

        UpdateExpiredAccessTokensJob::dispatch(
            force: $force,
        );
    }
}
