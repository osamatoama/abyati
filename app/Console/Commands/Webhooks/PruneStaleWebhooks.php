<?php

namespace App\Console\Commands\Webhooks;

use App\Models\Webhook;
use Illuminate\Console\Command;

class PruneStaleWebhooks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'webhooks:prune-stale';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prune stale webhooks';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $staleWebhooksQ = Webhook::query()
            ->where('created_at', '<', now()->subDays(7));

        $staleWebhooksCount = (clone $staleWebhooksQ)->count();

        (clone $staleWebhooksQ)->delete();

        $log = 'Stale webhooks pruned successfully. Total: ' . $staleWebhooksCount;

        logger()->debug($log);
        $this->info($log);
    }
}
