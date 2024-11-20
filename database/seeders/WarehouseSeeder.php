<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $branches = Branch::doesntHave('warehouse')->get();

        $branches->each(function ($branch) {
            $branch->warehouse()->create([
                'name' => $branch->name,
                'is_default' => true,
                'active' => true,
            ]);
        });
    }
}
