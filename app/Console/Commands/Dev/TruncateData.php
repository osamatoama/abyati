<?php

namespace App\Console\Commands\Dev;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TruncateData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dev:truncate-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Truncate data after pre-live tests';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // $this->error("Can't run this command outside dev env");
        // return;

        $this->info('Truncating data...');

        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        DB::table('customers')->truncate();
        DB::table('orders')->truncate();
        DB::table('order_items')->truncate();
        DB::table('order_item_codes')->truncate();
        DB::table('order_urls')->truncate();
        DB::table('products')->truncate();
        DB::table('product_stc_configurations')->truncate();
        DB::table('purchase_failures')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
