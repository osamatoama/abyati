<?php

namespace App\Imports\Admin\Shelf;

use App\Models\Shelf;
use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ShelfProductsImport implements ToCollection
{
    public function __construct(
        public Warehouse $warehouse,
        public Shelf $shelf,
    )
    {
        //
    }

    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        $column = $this->transpose($rows)[0] ?? [];
        array_shift($column);

        $barcodes = collect($column);

        $barcodes = collect($column)->map(fn ($value) => trim((string) $value))
            ->filter(fn ($value) => filled($value));

        if ($barcodes->isEmpty()) {
            return;
        }

        $productIds = Product::select('id', 'sku')
            ->whereIn('sku', $barcodes->toArray())
            ->pluck('id')
            ->toArray();

        $this->shelf->products()->sync($productIds);
    }

    private function transpose(Collection $rows)
    {
        $array = $rows->toArray();

        return array_map(null, ...$array);
    }
}
