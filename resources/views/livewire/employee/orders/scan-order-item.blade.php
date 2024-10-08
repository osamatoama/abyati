<div class="modal fade scan-item-modal" id="scan-item-{{ $item->id }}-modal" tabindex="-1" aria-labelledby="scan-item-{{ $item->id }}-modal-label" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="scan-item-{{ $item->id }}-modal-label">
                    {{ $item->product->name }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div>
                    {{-- <form wire:submit.prevent="scan"> --}}
                    <form>
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
                            <div class="col-12" wire:ignore>
                                <div id="qr-reader"></div>
                            </div>

                            <div class="col-12 mb-5">
                                <label class="form-label">{{ __('employee.products.attributes.barcode') }}</label>

                                {{-- <input type="text" class="scan-barcode-input form-control @error('scanned_barcode') is-invalid @enderror" wire:model="scanned_barcode" wire:keyup.debounce.200ms="scan" /> --}}
                                <input type="text" class="scan-barcode-input form-control @error('scanned_barcode') is-invalid @enderror" wire:model="scanned_barcode" wire:keyup="scan" />

                                @error('scanned_barcode') <span class="form-input-error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        {{-- <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-sm btn-primary" data-kt-menu-dismiss="true">
                                {{ __('employee.orders.actions.scan_item') }}
                            </button>
                        </div> --}}
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
