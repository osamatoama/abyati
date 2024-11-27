<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = json_decode(
            json: file_get_contents(
                filename: database_path('seeders/json/cities.json'),
            ),
            associative: true,
        );

        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        DB::table('cities')->truncate();

        foreach (array_chunk($cities, 1000) as $chunk) {
            DB::table('cities')->insert($chunk);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
