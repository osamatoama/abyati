<?php

namespace App\Console\Commands\Orders;

use App\Models\Store;
use Illuminate\Console\Command;
use App\Jobs\Salla\Pull\Orders\PullOrdersJob;

class DailySyncOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:daily-sync-orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync salla orders daily.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $stores = Store::get();

        foreach ($stores as $i => $store) {
            $store->load(
                relations: ['user.sallaToken'],
            );

            PullOrdersJob::dispatch(
                accessToken: $store->user->sallaToken->access_token,
                storeId: $store->id,
                filters: [
                    'from_date' => now('utc')->subDays(1)->format('Y-m-d'),
                ],
            )->delay(now('utc')->addMinutes(1 * $i));
        }
    }
}
