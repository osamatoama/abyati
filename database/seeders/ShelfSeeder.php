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
        // $this->seedTabukShelves();
        $this->seedRiyadhShelves();
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
                'suffixes' => [1, 1],
                'dir' => null,
            ],
            'N' => [
                'suffixes' => [1, 1],
                'dir' => null,
            ],
            'O' => [
                'suffixes' => [1, 24],
                'dir' => null,
            ],
            'X' => [
                'suffixes' => [1, 1],
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
                Shelf::firstOrCreate([
                    'warehouse_id' => $tabukWarehouse->id,
                    'name' => $shelfName,
                ], [
                    'aisle' => $aisle,
                    'order' => $order++,
                ]);
            }
        }
    }

    private function seedRiyadhShelves(): void
    {
        $riyadhWarehouse = Warehouse::firstWhere('name', 'الرياض');

        if (! $riyadhWarehouse) {
            return;
        }

        $shelvesStructure = [
            'A' => [
                'suffixes' => [1, 6],
                'dir' => 'asc',
            ],
            'B' => [
                'suffixes' => [1, 5],
                'dir' => 'desc',
            ],
            'C' => [
                'suffixes' => [1, 3],
                'dir' => 'asc',
            ],
            'D' => [
                'suffixes' => [1, 3],
                'dir' => 'desc',
            ],
            'E' => [
                'suffixes' => [1, 5],
                'dir' => 'asc',
            ],
            'F' => [
                'suffixes' => [1, 5],
                'dir' => 'desc',
            ],
            'G' => [
                'suffixes' => [1, 13],
                'dir' => 'asc',
            ],
            'H' => [
                'suffixes' => [1, 7],
                'dir' => 'desc',
            ],
            'I' => [
                'suffixes' => [1, 3],
                'dir' => 'asc',
            ],
            'J' => [
                'suffixes' => [1, 9],
                'dir' => 'desc',
            ],
            'K' => [
                'suffixes' => [1, 8],
                'dir' => 'asc',
            ],
            'L' => [
                'suffixes' => [1, 4],
                'dir' => 'desc',
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
                Shelf::firstOrCreate([
                    'warehouse_id' => $riyadhWarehouse->id,
                    'name' => $shelfName,
                ], [
                    'aisle' => $aisle,
                    'order' => $order++,
                ]);
            }
        }
    }
}
