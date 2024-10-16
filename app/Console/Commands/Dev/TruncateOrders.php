<?php

namespace App\Console\Commands\Dev;

use App\Models\Employee;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TruncateOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dev:truncate-orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Truncate orders after pre-live tests';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (app()->isProduction()) {
            $this->error("Can't run this command outside dev env");
            return;
        }

        $this->info('Truncating data...');

        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        Employee::whereNotNull('id')->update([
            'current_assigned_order_id' => null,
        ]);

        DB::table('orders')->truncate();
        DB::table('order_executions')->truncate();
        DB::table('order_execution_histories')->truncate();
        DB::table('order_items')->truncate();
        DB::table('order_item_notes')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
