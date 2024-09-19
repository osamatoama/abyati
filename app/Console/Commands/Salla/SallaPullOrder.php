<?php

namespace App\Console\Commands\Salla;

use App\Models\Store;
use Illuminate\Console\Command;
use App\Jobs\Salla\Pull\Orders\PullOrderJob;

class SallaPullOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'salla:pull-orders {--store=} {--order=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pull single order data from Salla API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $store = Store::findOrFail($this->option('store'));

        $store->load(
            relations: ['user.sallaToken'],
        );

        PullOrderJob::dispatch(
            accessToken: $store->user->sallaToken->access_token,
            storeId: $store->id,
            data: [
                'id' => $this->option('order'),
            ],
        );
    }
}
