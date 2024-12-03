<?php

namespace App\Console\Commands\Salla;

use Carbon\Carbon;
use App\Models\Store;
use App\Enums\Queues\QueueName;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;
use App\Jobs\Salla\Pull\Orders\PullOrdersJob;

class SallaPullOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'salla:pull-orders {--stores=} {--from=} {--to=} {--only-branch-statuses}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pull orders data from Salla API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $storeIds = $this->option('stores') ?? null;
        $fromDate = $this->option('from') ?? null;
        $toDate = $this->option('to') ?? null;
        $onlyBranchStatuses = $this->option('only-branch-statuses') ?? false;

        $filters = [];

        if (filled($fromDate)) {
            $filters['from_date'] = Carbon::parse($fromDate)->format('d-m-Y');
        }
        if (filled($toDate)) {
            $filters['to_date'] = Carbon::parse($toDate)->addDay()->format('d-m-Y');
        }

        $stores = Store::query()
            ->when(
                filled($storeIds),
                fn ($query) => $query->whereIn('id', explode(',', $storeIds)),
            )
            ->get();

        $jobs = [];

        foreach ($stores as $store) {
            $this->info("Queueing pulls for store $store->id:");

            $store->load(
                relations: ['user.sallaToken'],
            );

            $jobs[] = new PullOrdersJob(
                accessToken: $store->user->sallaToken->access_token,
                storeId: $store->id,
                filters: $filters,
                onlyBranchStatuses: $onlyBranchStatuses,
            );

            $this->line('Orders');
        }

        Bus::chain($jobs)
            ->onQueue(QueueName::PULL)
            ->dispatch();
    }
}
