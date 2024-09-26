<?php

namespace App\Console\Commands\Salla;

use App\Models\Store;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;
use App\Jobs\Salla\Pull\Products\PullProductsJob;

class SallaPullProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'salla:pull-products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pull products data from Salla API';

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
        }

        Bus::chain($jobs)->dispatch();
    }
}
