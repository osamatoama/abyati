<?php

namespace Database\Seeders;

use App\Models\OrderItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FixOrderItemIssueQuantitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OrderItem::whereColumn('executed_quantity', '<', 'quantity')
            ->whereIn('completion_status', ['quantity_issues', 'completed'])
            ->each(fn (OrderItem $item) => $item->update([
                'issue_quantity' => $item->quantity - $item->executed_quantity,
            ]));
    }
}
