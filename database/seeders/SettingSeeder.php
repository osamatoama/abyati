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
        $generalSettings = [
            [
                'source' => SettingSource::SYSTEM,
                'type' => SettingType::TAGS,
                'key' => 'enable_order_auto_tagging',
                'value' => 1,
            ],
        ];

        $storeSettings = [
            [
                'source' => SettingSource::SYSTEM,
                'type' => SettingType::PRODUCTS,
                'key' => 'frozen_product_categories',
                'value' => json_encode([808268209]),
            ],
        ];

        foreach ($generalSettings as $setting) {
            Setting::updateOrCreate([
                'type' => $setting['type'],
                'key' => $setting['key'],
            ], [
                'store_id' => null,
                'source' => $setting['source'],
                'value' => $setting['value'],
            ]);
        }

        foreach (Store::get() as $store) {
            foreach ($storeSettings as $setting) {
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
        $generalSettings = [
            [
                'source' => SettingSource::SYSTEM,
                'type' => SettingType::TAGS,
                'key' => 'enable_order_auto_tagging',
                'value' => 0,
            ],
        ];

        $storeSettings = [
            [
                'source' => SettingSource::SYSTEM,
                'type' => SettingType::PRODUCTS,
                'key' => 'frozen_product_categories',
                'value' => json_encode([396489095]),
            ],
        ];

        foreach ($generalSettings as $setting) {
            Setting::updateOrCreate([
                'type' => $setting['type'],
                'key' => $setting['key'],
            ], [
                'store_id' => null,
                'source' => $setting['source'],
                'value' => $setting['value'],
            ]);
        }

        foreach (Store::get() as $store) {
            foreach ($storeSettings as $setting) {
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
