<div class="scanner">
    <form wire:submit.prevent="scan">
        <div class="mb-3 mb-md-10">
            <div class="col-12 mb-3 mb-md-5">
                <label class="form-label">{{ __('admin.products.attributes.barcode') }}</label>

                <input type="text" id="scanned_barcode" class="scan-barcode-input form-control @error('scanned_barcode') is-invalid @enderror" wire:model="scanned_barcode" wire:keyup.debounce.500ms="scan" wire:loading.attr="disabled" />

                {{-- <div class="d-flex gap-3">
                    <input type="text" id="scanned_barcode" class="scan-barcode-input form-control @error('scanned_barcode') is-invalid @enderror" wire:model="scanned_barcode" wire:keyup.debounce.500ms="scan" wire:loading.attr="disabled" />

                    <button id="camera-btn" class="btn btn-info">
                        <i class="fas fa-camera pe-0"></i>
                    </button>
                </div> --}}

                @error('scanned_barcode') <span class="form-input-error text-danger">{{ $message }}</span> @enderror
            </div>
        </div>

        @if($scanned_product)
            <div class="row product-image-wrapper mb-3 mb-md-5">
                <div class="col-6">
                    <img src="{{ $scanned_product->main_image }}" class="img-fluid">
                </div>

                <div class="col-6">
                    <div>
                        <div class="product-name">
                            {{ $scanned_product->name }}
                        </div>
                    </div>

                    {{-- <div class="d-flex align-items-center">
                        <ul class="list-unstyled fs-lg">
                            <li>
                                <strong>{{ __('admin.orders.items.attributes.quantity') }} = </strong>
                                <span>{{ $scanned_product->quantity }}</span>
                            </li>
                            <li>
                                <strong>{{ __('admin.orders.items.attributes.executed_quantity') }} = </strong>
                                <span>{{ $scanned_product->executed_quantity }}</span>
                            </li>
                        </ul>
                    </div> --}}
                </div>
            </div>
        @endif
    </form>
</div>

@script
<script>
    $('.scan-barcode-input').focus()
</script>
@endscript
