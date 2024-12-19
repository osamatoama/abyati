<?php

namespace App\Console\Commands\Salla;

use App\Models\Store;
use Illuminate\Console\Command;
use App\Jobs\Salla\Pull\Products\PullProductJob;
use App\Services\Salla\Merchant\SallaMerchantService;
use App\Services\Salla\Merchant\SallaMerchantException;

class SallaPullProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'salla:pull-product {--store=} {--product=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pull single product data from Salla API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $store = Store::findOrFail($this->option('store'));
        $productId = $this->option('product');

        if (empty($productId)) {
            $this->error('Product ID is required');

            return;
        }

        $store->load(
            relations: ['user.sallaToken'],
        );

        try {
            $response = SallaMerchantService::withToken(
                    accessToken: $store->user->sallaToken->access_token,
                )
                ->products()
                ->details(
                    id: $productId,
                );
        } catch (SallaMerchantException $exception) {
            $this->error('Failed to pull product data from Salla');

            return;
        }

        PullProductJob::dispatch(
            accessToken: $store->user->sallaToken->access_token,
            storeId: $store->id,
            data: $response['data'],
        );
    }
}
