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

        DB::table('branch_order_statuses')->truncate();

        DB::table('orders')->truncate();
        DB::table('order_execution_histories')->truncate();
        DB::table('order_items')->truncate();
        DB::table('order_item_notes')->truncate();
        DB::table('order_statuses')->truncate();

        DB::table('products')->truncate();
        DB::table('product_variants')->truncate();
        DB::table('product_variant_option_values')->truncate();
        DB::table('options')->truncate();
        DB::table('option_values')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
