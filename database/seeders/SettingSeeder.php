<?php

namespace Database\Seeders;

use App\Models\Store;
use App\Models\Setting;
use App\Enums\SettingType;
use App\Enums\SettingSource;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()->environment('production')
            ? $this->seedForProduction()
            : $this->seedForDevelopment();
    }

    /**
     * Seed for development.
     */
    private function seedForDevelopment(): void
    {
        $settings = [
            [
                'source' => SettingSource::SYSTEM,
                'type' => SettingType::PRODUCTS,
                'key' => 'frozen_product_categories',
                'value' => json_encode([808268209]),
            ],
        ];

        foreach (Store::get() as $store) {
            foreach ($settings as $setting) {
                Setting::updateOrCreate([
                    'store_id' => $store->id,
                    'type' => $setting['type'],
                    'key' => $setting['key'],
                ], [
                    'source' => $setting['source'],
                    'value' => $setting['value'],
                ]);
            }
        }
    }

    /**
     * Seed for production.
     */
    private function seedForProduction(): void
    {
        $settings = [
            [
                'source' => SettingSource::SYSTEM,
                'type' => SettingType::PRODUCTS,
                'key' => 'frozen_product_categories',
                'value' => json_encode([396489095]),
            ],
        ];

        foreach (Store::get() as $store) {
            foreach ($settings as $setting) {
                Setting::updateOrCreate([
                    'store_id' => $store->id,
                    'type' => $setting['type'],
                    'key' => $setting['key'],
                ], [
                    'source' => $setting['source'],
                    'value' => $setting['value'],
                ]);
            }
        }
    }
}
