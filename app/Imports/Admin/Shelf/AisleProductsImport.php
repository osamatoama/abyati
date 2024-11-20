<?php

namespace App\Imports\Admin\Shelf;

use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class AisleProductsImport implements ToCollection
{
    public function __construct(
        public Warehouse $warehouse,
        public string $aisle,
    )
    {
        //
    }

    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        $columns = $this->transpose($rows);
        array_shift($columns);

        foreach ($columns as $column) {
            $column = collect($column);

            $shelfName = trim($column->shift());

            if (empty($shelfName)) {
                continue;
            }

            $shelfDescription = trim($column->shift());
            $shelfDescription = filled($shelfDescription) ? $shelfDescription : null;

            $shelf = $this->warehouse->shelves()->firstWhere('name', $shelfName);

            if (empty($shelf)) {
                $shelf = $this->warehouse->shelves()->create([
                    'aisle' => $this->aisle,
                    'name' => $shelfName,
                    'description' => $shelfDescription,
                ]);
            } elseif ($shelf->description !== $shelfDescription) {
                $shelf->update([
                    'description' => $shelfDescription,
                ]);
            }

            $column = $column->map(fn ($value) => trim((string) $value))
                ->filter(fn ($value) => filled($value));

            if ($column->isEmpty()) {
                continue;
            }

            $productIds = Product::select('id', 'sku')
                ->whereIn('sku', $column->toArray())
                ->pluck('id')
                ->toArray();

            /**
             * TEMP: For Debug
             */
            // $wrongBarcodes = $column->diff(Product::whereIn('sku', $column->toArray())->pluck('sku'));

            // cache()->put('import_shelves_missing_barcodes', array_merge(
            //     cache()->get('import_shelves_missing_barcodes', []),
            //     $wrongBarcodes->toArray(),
            // ));

            $shelf->products()->sync($productIds);
        }
    }

    private function transpose(Collection $rows)
    {
        $array = $rows->toArray();

        return array_map(null, ...$array);
    }
}
