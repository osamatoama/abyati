<?php

namespace Database\Seeders;

use App\Models\Stocktaking;
use Illuminate\Database\Seeder;
use App\Enums\StocktakingStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Services\Stocktakings\SyncStocktakingStatusWithProducts;

class FixStocktakingStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stocktakings = Stocktaking::query()
            ->where('status', StocktakingStatus::PENDING->value)
            ->get();

        foreach ($stocktakings as $stocktaking) {
            (new SyncStocktakingStatusWithProducts(
                stocktaking: $stocktaking,
            ))->execute();
        }
    }
}
