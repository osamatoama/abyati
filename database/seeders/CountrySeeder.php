<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries = json_decode(
            json: file_get_contents(
                filename: database_path('seeders/json/countries.json'),
            ),
            associative: true,
        );

        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        DB::table('countries')->truncate();
        DB::table('countries')->insert($countries);

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
