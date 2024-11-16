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

        foreach ($columns as $column) {
            $column = collect($column);

            $column = $column->filter(fn ($value) => $value !== null);

            if ($column->isEmpty()) {
                continue;
            }

            $shelfName = trim($column->shift());

            $shelf = $this->warehouse->shelves()->firstWhere('name', $shelfName);

            if (empty($shelf)) {
                continue;
            }

            $productIds = Product::select('id', 'sku')
                ->whereIn('sku', $column->toArray())
                ->pluck('id')
                ->toArray();

            $shelf->products()->sync($productIds);
        }
    }

    private function transpose(Collection $rows)
    {
        $array = $rows->toArray();

        return array_map(null, ...$array);
    }
}
