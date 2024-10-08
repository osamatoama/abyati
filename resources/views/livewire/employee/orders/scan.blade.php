<div class="modal fade scan-item-modal" id="scan-modal" tabindex="-1" aria-labelledby="scan-modal-label" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="scan-modal-label">
                    {{ __('employee.orders.actions.scan_barcode') }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div>
                    @if($enable)
                        <form wire:submit.prevent="scan">
                            <div class="mb-10">
                                <div class="col-12" wire:ignore>
                                    <div id="qr-reader"></div>
                                </div>

                                <div class="col-12 mb-5">
                                    <label class="form-label">{{ __('employee.products.attributes.barcode') }}</label>

                                    <input type="text" class="scan-barcode-input form-control @error('scanned_barcode') is-invalid @enderror" wire:model="scanned_barcode" />
                                    {{-- <input type="text" class="scan-barcode-input form-control @error('scanned_barcode') is-invalid @enderror" wire:model="scanned_barcode" wire:keyup="scan" /> --}}

                                    @error('scanned_barcode') <span class="form-input-error text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            @if($scanned_item)
                                <div class="row product-image-wrapper mb-5">
                                    <div class="col-md-6">
                                        <img src="{{ $scanned_item->product->main_image }}" class="img-fluid">
                                    </div>

                                    <div class="col-md-6 d-flex align-items-center justify-content-center">
                                        <ul class="list-unstyled fs-lg">
                                            <li>
                                                <strong>{{ __('employee.orders.items.attributes.quantity') }} = </strong>
                                                <span>{{ $scanned_item->quantity }}</span>
                                            </li>
                                            <li>
                                                <strong>{{ __('employee.orders.items.attributes.executed_quantity') }} = </strong>
                                                <span>{{ $scanned_item->executed_quantity }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            @endif

                            {{-- <div class="d-flex justify-content-end"> --}}
                            <div class="d-none justify-content-end">
                                <button type="submit" class="btn btn-sm btn-primary" data-kt-menu-dismiss="true">
                                    {{ __('employee.orders.actions.scan_item') }}
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="alert bg-success text-white fw-semibold">
                            {{ __('employee.orders.messages.order_executed') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
