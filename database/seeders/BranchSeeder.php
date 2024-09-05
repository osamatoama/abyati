<?php

namespace Database\Seeders;

use App\Models\Store;
use App\Models\Branch;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (Store::all() as $store) {
            Branch::updateOrCreate([
                'store_id' => $store->id,
                'name' => 'الرياض',
            ], [
                'related_order_status_id' => null,
                'active' => true,
            ]);

            Branch::updateOrCreate([
                'store_id' => $store->id,
                'name' => 'تبوك',
            ], [
                'related_order_status_id' => null,
                'active' => true,
            ]);
        }
    }
}
