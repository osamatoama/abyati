<?php

namespace App\Jobs\Shelf;

use App\Models\Warehouse;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Imports\Admin\Shelf\WarehouseProductsImport;

class ImportWarehouseProductsJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Warehouse $warehouse,
        public string $file,
    )
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Excel::import(
            import: new WarehouseProductsImport(
                warehouse: $this->warehouse,
            ),
            filePath: $this->file,
        );

        logger()->debug(
            message: 'Warehouse products imported',
            context: [
                'warehouse_id' => $this->warehouse->id,
            ],
        );
    }
}
