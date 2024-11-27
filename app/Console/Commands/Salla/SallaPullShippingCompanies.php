<?php

namespace App\Console\Commands\Salla;

use App\Models\Store;
use App\Enums\Queues\QueueName;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;
use App\Jobs\Salla\Pull\ShippingCompanies\PullShippingCompaniesJob;

class SallaPullShippingCompanies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'salla:pull-shipping-companies {--stores=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pull shipping companies data from Salla API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $storeIds = $this->option('stores');

        $stores = Store::query()
            ->supplier()
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

            $jobs[] = new PullShippingCompaniesJob(
                accessToken: $store->user->sallaToken->access_token,
                storeId: $store->id,
            );

            $this->line('ShippingCompanies');
        }

        Bus::chain($jobs)
            ->onQueue(QueueName::PULL)
            ->dispatch();
    }
}
