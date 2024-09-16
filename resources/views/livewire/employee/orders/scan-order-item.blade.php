<div>
    <form wire:submit.prevent="scan">
        <div class="row product-image-wrapper mb-5">
            <div class="col-md-6">
                <img src="{{ $item->product->main_image }}" class="img-fluid">
            </div>

            <div class="col-md-6 d-flex align-items-center justify-content-center">
                <ul class="list-unstyled fs-lg">
                    <li>
                        <strong>{{ __('employee.orders.items.attributes.quantity') }} = </strong>
                        <span>{{ $item->quantity }}</span>
                    </li>
                    <li>
                        <strong>{{ __('employee.orders.items.attributes.executed_quantity') }} = </strong>
                        <span>{{ $item->executed_quantity }}</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="mb-10">
            <div class="col-12 mb-5">
                <label class="form-label">{{ __('employee.products.attributes.barcode') }}</label>

                <input id="filter-date" type="text" class="form-control @error('scanned_barcode') is-invalid @enderror" wire:model="scanned_barcode" />

                @error('scanned_barcode') <span class="form-input-error text-danger">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-sm btn-primary" data-kt-menu-dismiss="true">
                {{ __('employee.orders.actions.scan_item') }}
            </button>
        </div>
    </form>
</div>
