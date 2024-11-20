<?php

namespace App\Imports\Admin\Shelf;

use App\Models\Warehouse;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class WarehouseProductsImport implements WithMultipleSheets
{
    public $aisles = [];

    public function __construct(
        public Warehouse $warehouse,
    )
    {
        $this->aisles = $this->warehouse->getAisles();
    }

    public function sheets(): array
    {
        return array_map(
            array: $this->aisles,
            callback: fn ($aisle) => new AisleProductsImport(
                warehouse: $this->warehouse,
                aisle: $aisle,
            ),
        );
    }
}
