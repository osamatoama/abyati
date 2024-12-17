<?php

namespace App\Livewire\Employee\Stocktakings;

use App\Models\Product;
use Livewire\Component;
use App\Models\Stocktaking;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Locked;
use App\Services\Stocktakings\ConfirmProduct;

class Scan extends Component
{
    #[Locked]
    public Stocktaking $stocktaking;

    public bool $enable = false;

    public ?string $scanned_barcode = null;

    public ?Product $scanned_product = null;

    public bool $has_issue = false;

    public function boot()
    {
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

        $this->reset('scanned_product', 'has_issue');

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

        $this->reset('scanned_barcode');
    }

    public function confirm()
    {
        (new ConfirmProduct(
            stocktaking: $this->stocktaking,
            product: $this->scanned_product,
        ))->execute();

        $this->dispatch('product-confirmed', [
            'product_id' => $this->scanned_product->id,
        ]);
    }

    public function hasIssue()
    {
        $this->has_issue = true;

        // $this->dispatch('scan-error');
    }

    public function updateExpiryDate($date)
    {
        dd($date);
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
