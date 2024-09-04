<?php

namespace App\Console\Commands\Stores;

use App\Models\Store;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Artisan;
use App\Jobs\Salla\Pull\Orders\PullOrdersJob;
use App\Jobs\Salla\Pull\Coupons\PullCouponsJob;
use App\Jobs\Salla\Pull\Products\PullProductsJob;
use App\Jobs\Salla\Pull\OrderStatuses\PullOrderStatusesJob;

class PullStoresData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:pull-stores-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pull stores data from Salla API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $stores = Store::get();
        $jobs = [];

        foreach ($stores as $store) {
            $this->info("Queueing pulls for store $store->id:");

            $store->load(
                relations: ['user.sallaToken'],
            );

            $jobs[] = new PullProductsJob(
                accessToken: $store->user->sallaToken->access_token,
                storeId: $store->id,
            );
            $this->line('Products');

            $jobs[] = new PullOrderStatusesJob(
                accessToken: $store->user->sallaToken->access_token,
                storeId: $store->id,
            );
            $this->line('Order Statuses');

            $jobs[] = new PullCouponsJob(
                accessToken: $store->user->sallaToken->access_token,
                storeId: $store->id,
                marketingOnly: true,
            );
            $this->line('Coupons');
        }

        $jobs[] = function () {
            Artisan::call(
                command: 'db:seed',
                parameters: [
                    '--class' => 'PaymentTermSeeder',
                    '--force' => true,
                ]
            );
        };

        foreach ($stores as $store) {
            $jobs[] = function () use ($store) {
                dispatch(new PullOrdersJob(
                    accessToken: $store->user->sallaToken->access_token,
                    storeId: $store->id,
                    hasMarketingCouponOnly: true,
                ));
            };
            $this->info("Queueing Order pulls for store $store->id");
        }

        Bus::chain($jobs)->dispatch();
    }
}
