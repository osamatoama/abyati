<?php

namespace App\Livewire\Admin\Shelves;

use App\Models\Shelf;
use Livewire\Component;
use App\Models\Product;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Locked;

class ScanProducts extends Component
{
    #[Locked]
    public Shelf $shelf;

    public ?string $scanned_barcode = null;

    public ?Product $scanned_product = null;

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
        return view('livewire.admin.shelves.scan-products');
    }

    public function scan()
    {
        if (empty($this->scanned_barcode)) {
            return;
        }

        $this->reset('scanned_product');

        $this->resetErrorBag();

        $this->validate();

        $product = Product::query()
            ->where('sku', $this->scanned_barcode)
            ->first();

        $this->shelf->products()->syncWithoutDetaching($product?->id ?? []);

        $this->dispatch('product-scanned', [
            'product_id' => $product->id,
        ]);

        $this->reset('scanned_barcode');
    }

    public function rules(): array
    {
        $shelfProductIds = $this->shelf->products->pluck('sku')->toArray();

        return [
            'scanned_barcode' => [
                'required',
                Rule::exists('products', 'sku'),
                Rule::notIn($shelfProductIds),
            ],
        ];
    }

    protected function validationAttributes()
    {
        return [
            'scanned_barcode' => __('admin.products.attributes.barcode'),
        ];
    }

    protected function messages()
    {
        return [
            'scanned_barcode.exists' => __('admin.shelves.errors.invalid_barcode'),
            'scanned_barcode.not_in' => __('admin.shelves.errors.product_already_attached'),
        ];
    }
}
