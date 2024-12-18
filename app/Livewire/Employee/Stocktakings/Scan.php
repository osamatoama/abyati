<?php

namespace App\Livewire\Employee\Stocktakings;

use App\Models\Shelf;
use App\Models\Branch;
use App\Models\Product;
use Livewire\Component;
use App\Models\Warehouse;
use App\Models\Stocktaking;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Locked;
use App\Services\Stocktakings\ConfirmProduct;
use App\Services\Products\Actions\UpdateProductQuantity;
use App\Services\Products\Actions\UpdateProductExpiryDate;

class Scan extends Component
{
    #[Locked]
    public Stocktaking $stocktaking;

    public bool $enable = false;

    public ?string $scanned_barcode = null;

    public ?Product $scanned_product = null;

    public ?int $scanned_product_old_quantity = null;

    public ?int $scanned_product_quantity = null;

    public ?string $scanned_product_old_expiry_date = null;

    public ?string $scanned_product_expiry_date = null;

    public bool $edit_mode = false;

    public bool $has_issue = false;

    public function boot()
    {
        // $this->shelf = $this->stocktaking->shelf;
        // $this->warehouse = $this->shelf->warehouse;
        // $this->branch = $this->warehouse->branch;

        $this->withValidator(function ($validator) {
            if ($validator->fails()) {
                $this->dispatch('scan-error');
            }
        });
    }

    public function render()
    {
        $this->enable = ! $this->stocktaking->isCompleted();

        return view('livewire.employee.stocktakings.scan');
    }

    public function scan()
    {
        if (empty($this->scanned_barcode)) {
            return;
        }

        $this->scanned_barcode = trim($this->scanned_barcode);

        $this->reset(
            'scanned_product',
            'scanned_product_quantity',
            'scanned_product_expiry_date',
            'has_issue',
            'edit_mode',
        );

        $this->resetErrorBag();

        $this->validate();

        $product = $this->stocktaking
            ->shelf
            ->products()
            ->where('sku', $this->scanned_barcode)
            ->with([
                'quantities' => fn($q) => $q->where('branch_id', $this->stocktaking->shelf->warehouse->branch_id),
                'shelves' => fn($q) => $q->where('warehouse_id', $this->stocktaking->shelf->warehouse_id),
            ])
            ->first();

        $this->scanned_product = $product;

        $this->scanned_product_quantity = $product->quantities->sum('quantity') ?? 0;
        $this->scanned_product_old_quantity = $this->scanned_product_quantity;

        $this->scanned_product_expiry_date = $product->quantities->first()?->expiry_date?->format('Y-m-d') ?? null;
        $this->scanned_product_old_expiry_date = $this->scanned_product_expiry_date;
    }

    public function confirm()
    {
        (new ConfirmProduct(
            stocktaking: $this->stocktaking,
            product: $this->scanned_product,
        ))->execute();

        $scannedProductId = $this->scanned_product->id;

        $this->reset(
            'scanned_barcode',
            'scanned_product',
            'scanned_product_quantity',
            'scanned_product_expiry_date',
            'has_issue',
            'edit_mode',
        );

        $this->dispatch('product-confirmed', [
            'product_id' => $scannedProductId,
        ]);
    }

    public function hasIssue()
    {
        $this->has_issue = true;

        // $this->dispatch('scan-error');
    }

    public function updateProduct()
    {
        $this->updateExpiryDate($this->scanned_product_expiry_date);
        $this->updateQuantity($this->scanned_product_quantity);

        $this->reset('edit_mode');

        $this->dispatch('product-updated', [
            'product_id' => $this->scanned_product->id,
            'message' => __('employee.stocktakings.messages.product_updated'),
        ]);
    }

    private function updateExpiryDate($date)
    {
        if ($this->scanned_product_expiry_date == $this->scanned_product_old_expiry_date || ! $this->stocktaking?->shelf?->warehouse?->branch) {
            return;
        }

        (new UpdateProductExpiryDate(
            product: $this->scanned_product,
            branch: $this->stocktaking->shelf->warehouse->branch,
            expiryDate: $date,
        ))->execute();

        $this->dispatch('product-expiry-date-updated', [
            'product_id' => $this->scanned_product->id,
        ]);
    }

    private function updateQuantity($quantity)
    {
        if ($this->scanned_product_quantity == $this->scanned_product_old_quantity || ! $this->stocktaking?->shelf?->warehouse?->branch) {
            return;
        }

        (new UpdateProductQuantity(
            product: $this->scanned_product,
            branch: $this->stocktaking->shelf->warehouse->branch,
            quantity: $quantity,
            remoteUpdate: true,
        ))->execute();

        $this->dispatch('product-expiry-date-updated', [
            'product_id' => $this->scanned_product->id,
        ]);
    }

    private function getAvailableBarcodesToScan(): array
    {
        return $this->stocktaking
            ->shelf
            ->products()
            ->pluck('sku')
            ->toArray();
    }

    public function rules(): array
    {
        return [
            'scanned_barcode' => [
                'required',
                Rule::in($this->getAvailableBarcodesToScan()),
            ],
        ];
    }

    protected function validationAttributes()
    {
        return [
            'scanned_barcode' => __('employee.products.attributes.barcode'),
        ];
    }

    protected function messages()
    {
        return [
            'scanned_barcode.in' => __('employee.stocktakings.errors.invalid_barcode'),
        ];
    }
}
