<?php

namespace Database\Seeders;

use App\Models\Support;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SupportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (range(1, 3) as $i) {
            Support::create([
                'name' => 'موظف دعم ' . $i,
                'email' => 'support-' . $i . '@abyati.com',
                'password' => '123456',
                'active' => true,
                'phone' => '059999999' . ($i - 1),
            ]);
        }
    }
}
