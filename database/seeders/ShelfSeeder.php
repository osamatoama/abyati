<?php

namespace Database\Seeders;

use App\Models\Shelf;
use App\Models\Warehouse;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ShelfSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->seedTabukShelves();
    }

    private function seedTabukShelves(): void
    {
        $tabukWarehouse = Warehouse::firstWhere('name', 'تبوك');

        if (! $tabukWarehouse) {
            return;
        }

        $shelvesStructure = [
            'A' => [
                'suffixes' => [1, 22],
                'dir' => 'asc',
            ],
            'B' => [
                'suffixes' => [1, 19],
                'dir' => 'desc',
            ],
            'C' => [
                'suffixes' => [1, 19],
                'dir' => 'asc',
            ],
            'D' => [
                'suffixes' => [1, 19],
                'dir' => 'desc',
            ],
            'E' => [
                'suffixes' => [1, 19],
                'dir' => 'asc',
            ],
            'F' => [
                'suffixes' => [1, 19],
                'dir' => 'desc',
            ],
            'G' => [
                'suffixes' => [1, 19],
                'dir' => 'asc',
            ],
            'H' => [
                'suffixes' => [1, 19],
                'dir' => 'desc',
            ],
            'I' => [
                'suffixes' => [1, 18],
                'dir' => 'asc',
            ],
            'J' => [
                'suffixes' => [1, 18],
                'dir' => 'desc',
            ],
            'K' => [
                'suffixes' => [1, 18],
                'dir' => 'asc',
            ],
            'L' => [
                'suffixes' => [1, 18],
                'dir' => 'desc',
            ],
            'M' => [
                'suffixes' => [],
                'dir' => null,
            ],
        ];

        $order = 1;

        foreach ($shelvesStructure as $aisle => $structure) {
            $shelfNames = [];

            if (empty($structure['suffixes'])) {
                $shelfNames[] = $aisle;
            } else {
                $suffixes = $structure['suffixes'];

                if ($structure['dir'] === 'desc') {
                    $suffixes = array_reverse($suffixes);
                }

                foreach (range(...$suffixes) as $suffix) {
                    $shelfNames[] = $aisle . $suffix;
                }
            }

            foreach ($shelfNames as $shelfName) {
                Shelf::updateOrCreate([
                    'warehouse_id' => $tabukWarehouse->id,
                    'name' => $shelfName,
                ], [
                    'aisle' => $aisle,
                    'order' => $order++,
                ]);
            }
        }
    }
}
