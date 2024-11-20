<?php

namespace Database\Seeders;

use App\Models\OrderItem;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Services\Orders\Fulfillment\Employee\SyncOrderExecutionStatusWithItems;

class FixOrderItemExecutedQuantitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OrderItem::whereColumn('executed_quantity', '>', 'quantity')
            ->each(function (OrderItem $item) {
                $item->update([
                    'executed_quantity' => $item->quantity,
                ]);

                $item->setAsCompleted();

                (new SyncOrderExecutionStatusWithItems(
                    order: $item->order
                ))->execute();

                logger()->debug("Fixed Item #{$item->id} executed quantity in order #{$item->order_id}");
            });
    }
}
