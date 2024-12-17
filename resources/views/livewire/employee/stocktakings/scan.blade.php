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

                        <div class="d-flex align-items-center">
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
                                    <span>{{ $scanned_product->shelves->pluck('name')->implode(',') }}</span>
                                </li>
                                <li>
                                    <strong>{{ __('employee.products.attributes.quantity') }} = </strong>
                                    <span>{{ $scanned_product->quantities->sum('quantity') }}</span>
                                </li>
                                <li>
                                    {{ $scanned_product->quantities->first()->expiry_date?->format('U') }}
                                </li>
                                <li class="d-flex align-items-center gap-2">
                                    <strong>{{ __('employee.products.attributes.expiry_date') }} : </strong>
                                    <span>
                                        <input
                                            type="date" class="form-control form-control-sm"
                                            value="{{ $scanned_product->quantities->first()->expiry_date?->format('Y-m-d') ?? null }}"
                                            wire:change="updateExpiryDate($event.target.value)"
                                        />
                                    </span>
                                </li>
                            </ul>
                        </div>

                        @if(! $has_issue)
                            <div>
                                <button class="btn btn-sm btn-success" wire:click="confirm" wire:loading.attr="disabled">
                                    <i class="fas fa-circle-check"></i> {{ __('employee.stocktakings.actions.confirm') }}
                                </button>

                                <button class="btn btn-sm btn-danger" wire:click="hasIssue" wire:loading.attr="disabled">
                                    <i class="fas fa-exclamation-triangle"></i> {{ __('employee.stocktakings.actions.has_issue') }}
                                </button>
                            </div>
                        @endif

                        @if($has_issue)
                            <div>
                                <div>
                                    <select class="form-control" data-control="select2" data-placeholder="{{ __('employee.stocktakings.issues.select_issue') }}">
                                        <option value="">{{ __('employee.stocktakings.issues.select_issue') }}</option>

                                        @foreach(\App\Enums\StocktakingIssueType::toSelectArray() as $issueKey => $issueValue)
                                            <option value="{{ $issueKey }}">{{ $issueValue }}</option>
                                        @endforeach
                                    </select>

                                    {{-- <span id="edit-form-roles-error" class="form-input-error text-danger d-none"></span> --}}
                                </div>
                            </div>
                        @endif
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
