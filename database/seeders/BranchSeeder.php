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
        Branch::firstOrCreate([
            'name' => 'الرياض',
        ], [
            'active' => true,
        ]);

        Branch::firstOrCreate([
            'name' => 'تبوك',
        ], [
            'active' => true,
        ]);
    }
}
