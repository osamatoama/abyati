<div class="scanner">
    @if($enable)
        <form wire:submit.prevent="scan">
            <div class="mb-3 mb-md-10">
                <div class="col-12 mb-3 mb-md-5">
                    <label class="form-label">{{ __('employee.products.attributes.barcode') }}</label>

                    {{-- <input type="text" class="scan-barcode-input form-control @error('scanned_barcode') is-invalid @enderror" wire:model="scanned_barcode" /> --}}

                    <div class="d-flex gap-3">
                        <input type="text" id="scanned_barcode" class="scan-barcode-input form-control @error('scanned_barcode') is-invalid @enderror" wire:model="scanned_barcode" wire:keyup.debounce.500ms="scan" wire:loading.attr="disabled" />

                        <button id="camera-btn" class="btn btn-info">
                            <i class="fas fa-camera pe-0"></i>
                        </button>
                    </div>

                    @error('scanned_barcode') <span class="form-input-error text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            @if($scanned_item)
                <div class="row product-image-wrapper mb-3 mb-md-5">
                    <div class="col-6">
                        <img src="{{ $scanned_item->product->main_image }}" class="img-fluid">
                    </div>

                    <div class="col-6">
                        <div>
                            <div class="product-name">
                                {{ $scanned_item->product->name }}
                            </div>

                            @if($scanned_item->variant?->optionValues?->isNotEmpty())
                                <div class="product-variant">
                                    {{ $scanned_item->variant->optionValues->map(fn($optionValue) => $optionValue->option->name . ': ' . $optionValue->name)->implode(' - ') }}
                                </div>
                            @endif
                        </div>

                        <div class="d-flex align-items-center">
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

@script
<script>
    $('.scan-barcode-input').focus()
</script>
@endscript
