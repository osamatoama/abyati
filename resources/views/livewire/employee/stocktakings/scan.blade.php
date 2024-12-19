<div class="scanner">
    @if($enable)
        <form wire:submit.prevent="scan">
            <div class="mb-3 mb-md-10">
                <div class="col-12 mb-3 mb-md-5">
                    <label class="form-label">{{ __('employee.products.attributes.barcode') }}</label>

                    <div class="d-flex gap-3">
                        <input type="text" id="scanned_barcode" class="scan-barcode-input form-control @error('scanned_barcode') is-invalid @enderror" wire:model="scanned_barcode" wire:keyup.debounce.500ms="scan" wire:loading.attr="disabled" />

                        <button id="camera-btn" class="btn btn-info">
                            <i class="fas fa-camera pe-0"></i>
                        </button>
                    </div>

                    @error('scanned_barcode') <span class="form-input-error text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
        </form>

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

                    @if($edit_mode)
                        <div id="edit-product-info" class="d-flex align-items-center">
                            <ul class="list-unstyled fs-lg">
                                <li>
                                    <strong>{{ __('employee.products.attributes.barcode') }} :</strong>
                                    <span>{{ $scanned_product->sku }}</span>
                                </li>
                                <li>
                                    <strong>{{ __('employee.products.attributes.price') }} :</strong>
                                    <span>{{ $scanned_product->price }}</span>
                                </li>
                                <li>
                                    <strong>{{ __('employee.products.attributes.shelf') }} :</strong>
                                    <span>{{ $scanned_product->shelves->pluck('name')->implode(' , ') }}</span>
                                </li>
                                <li class="d-flex align-items-center gap-2 mb-1">
                                    <strong>{{ __('employee.products.attributes.quantity') }} : </strong>
                                    <span>
                                        <input type="number" class="form-control form-control-sm" wire:model="scanned_product_quantity" />
                                    </span>
                                </li>
                                <li class="d-flex align-items-center gap-2">
                                    <strong>{{ __('employee.products.attributes.expiry_date') }} : </strong>
                                    <span>
                                        <input type="date" class="form-control form-control-sm" wire:model="scanned_product_expiry_date" />
                                    </span>
                                </li>
                            </ul>
                        </div>
                    @else
                        <div id="show-product-info" class="d-flex align-items-center">
                            <ul class="list-unstyled fs-lg">
                                <li>
                                    <strong>{{ __('employee.products.attributes.barcode') }} :</strong>
                                    <span>{{ $scanned_product->sku }}</span>
                                </li>
                                <li>
                                    <strong>{{ __('employee.products.attributes.price') }} :</strong>
                                    <span>{{ $scanned_product->price }}</span>
                                </li>
                                <li>
                                    <strong>{{ __('employee.products.attributes.shelf') }} :</strong>
                                    <span>{{ $scanned_product->shelves->pluck('name')->implode(' , ') }}</span>
                                </li>
                                <li>
                                    <strong>{{ __('employee.products.attributes.quantity') }} = </strong>
                                    <span>{{ $scanned_product_quantity }}</span>
                                </li>
                                <li class="d-flex align-items-center gap-2">
                                    <strong>{{ __('employee.products.attributes.expiry_date') }} : </strong>
                                    <span>{{ $scanned_product_expiry_date ?? '---' }}</span>
                                </li>
                            </ul>
                        </div>
                    @endif

                    <div class="scan-actions">
                        @if(! $edit_mode)
                            <button class="btn btn-sm btn-success" wire:click="confirm" wire:loading.attr="disabled">
                                <i class="fas fa-circle-check"></i> {{ __('employee.stocktakings.actions.confirm') }}
                            </button>

                            <button class="btn btn-sm btn-primary" wire:click="$set('edit_mode', true)" wire:loading.attr="disabled">
                                <i class="fas fa-pen-to-square"></i> {{ __('employee.stocktakings.actions.edit') }}
                            </button>
                        @endif

                        @if($edit_mode)
                            <button id="save-product-update-btn" class="btn btn-sm btn-success" wire:loading.attr="disabled">
                                <i class="fas fa-circle-check"></i> {{ __('employee.stocktakings.actions.save_updates') }}
                            </button>

                            <button class="btn btn-sm btn-danger" wire:click="$set('edit_mode', false)" wire:loading.attr="disabled">
                                <i class="fas fa-ban"></i> {{ __('globals.discard') }}
                            </button>
                        @endif

                        {{-- <button class="btn btn-sm btn-danger" wire:click="hasIssue" wire:loading.attr="disabled">
                            <i class="fas fa-exclamation-triangle"></i> {{ __('employee.stocktakings.actions.has_issue') }}
                        </button> --}}
                    </div>

                    {{-- @if($has_issue)
                        <div>
                            <div>
                                <select class="form-control" data-control="select2" data-placeholder="{{ __('employee.stocktakings.issues.select_issue') }}">
                                    <option value="">{{ __('employee.stocktakings.issues.select_issue') }}</option>

                                    @foreach(\App\Enums\StocktakingIssueType::toSelectArray() as $issueKey => $issueValue)
                                        <option value="{{ $issueKey }}">{{ $issueValue }}</option>
                                    @endforeach
                                </select>

                                <span id="edit-form-roles-error" class="form-input-error text-danger d-none"></span>
                            </div>
                        </div>
                    @endif --}}
                </div>
            </div>
        @endif

        {{-- <div class="d-flex justify-content-end"> --}}
        <div class="d-none justify-content-end">
            <button type="submit" class="btn btn-sm btn-primary" data-kt-menu-dismiss="true">
                {{ __('employee.orders.actions.scan_item') }}
            </button>
        </div>
    @else
        <div class="alert bg-success text-white fw-semibold">
            {{ __('employee.orders.messages.order_executed') }}
        </div>
    @endif
</div>

@script
<script>
    $('.scan-barcode-input').focus()

    $(document).on('click', '#save-product-update-btn', function() {
        Swal.fire({
            title: '{{ __("employee.stocktakings.alerts.update_product") }}',
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: getTranslation('cancel'),
            confirmButtonText: getTranslation('confirm'),
        }).then(function (result) {
            if (result.value) {
                @this.updateProduct()
            }
        })
    })
</script>
@endscript
