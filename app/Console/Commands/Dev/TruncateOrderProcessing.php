<?php

namespace App\Console\Commands\Dev;

use App\Models\Order;
use App\Models\Employee;
use App\Models\OrderItem;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Enums\OrderCompletionStatus;
use App\Enums\OrderItemCompletionStatus;

class TruncateOrderProcessing extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dev:truncate-order-processing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Truncate order processing after pre-live tests';

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

        Order::whereNotNull('id')->update([
            'employee_id' => null,
            'completion_status' => OrderCompletionStatus::PENDING,
        ]);

        OrderItem::whereNotNull('id')->update([
            'executed_quantity' => 0,
            'issue_quantity' => 0,
            'completion_status' => OrderItemCompletionStatus::PENDING,
        ]);

        DB::table('order_executions')->truncate();
        DB::table('order_execution_histories')->truncate();
        DB::table('order_item_notes')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
