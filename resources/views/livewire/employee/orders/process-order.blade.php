<div>
    <div class="card">
        <div class="card-body">
            <div class="order-products">

                @if($executedItems->count())
                    <div class="h3">
                        تم التأكيد ({{ $executedItems->count() }})
                    </div>

                    <table class="table table-row-bordered">
                        <thead>
                            <th class="fw-bold">{{ __('employee.products.attributes.image') }}</th>
                            <th class="fw-bold">{{ __('employee.products.attributes.name') }}</th>
                            <th class="fw-bold">{{ __('employee.products.attributes.variant') }}</th>
                            <th class="fw-bold">{{ __('employee.products.attributes.barcode') }}</th>
                            <th class="fw-bold">{{ __('employee.orders.items.attributes.quantity') }}</th>
                            <th class="fw-bold">{{ __('employee.orders.items.attributes.executed_quantity') }}</th>
                        </thead>

                        <tbody>
                            @foreach($executedItems as $item)
                                @php
                                    $product = $item->product;
                                    $variant = $item->variant;
                                @endphp

                                <tr>
                                    <td>
                                        <img src="{{ $product->main_image }}" alt="{{ $product->name }}" class="img-fluid" style="max-width: 50px;">
                                    </td>
                                    <td>{{ $product->name }}</td>
                                    <td>
                                        @if($variant?->optionValues?->isNotEmpty())
                                            {{ $variant->optionValues->map(fn($optionValue) => $optionValue->option->name . ': ' . $optionValue->name)->implode(' - ') }}
                                        @else
                                            ---
                                        @endif
                                    </td>
                                    <td>{{ $variant->barcode }}</td>
                                    <td>
                                        {{ $item->quantity }}
                                    </td>
                                    <td>
                                        {{ $item->executed_quantity }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif

                @if($toExecuteItems->count())
                    <div class="h3">
                        قيد التأكيد ({{ $toExecuteItems->count() }})
                    </div>

                    <table class="table table-row-bordered">
                        <thead>
                            <th class="fw-bold">{{ __('employee.products.attributes.image') }}</th>
                            <th class="fw-bold">{{ __('employee.products.attributes.name') }}</th>
                            <th class="fw-bold">{{ __('employee.products.attributes.variant') }}</th>
                            <th class="fw-bold">{{ __('employee.products.attributes.barcode') }}</th>
                            <th class="fw-bold">{{ __('employee.orders.items.attributes.quantity') }}</th>
                            <th class="fw-bold">{{ __('employee.orders.items.attributes.executed_quantity') }}</th>
                            <th></th>
                        </thead>

                        <tbody>
                            @foreach($toExecuteItems as $item)
                                @php
                                    $product = $item->product;
                                    $variant = $item->variant;
                                @endphp

                                <tr>
                                    <td>
                                        <img src="{{ $product->main_image }}" alt="{{ $product->name }}" class="img-fluid" style="max-width: 50px;">
                                    </td>
                                    <td>{{ $product->name }}</td>
                                    <td>
                                        @if($variant?->optionValues?->isNotEmpty())
                                            {{ $variant->optionValues->map(fn($optionValue) => $optionValue->option->name . ': ' . $optionValue->name)->implode(' - ') }}
                                        @else
                                            ---
                                        @endif
                                    </td>
                                    <td>{{ $variant->barcode }}</td>
                                    <td>
                                        {{ $item->quantity }}
                                    </td>
                                    <td>
                                        {{ $item->executed_quantity }}
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#scan-item-{{ $item->id }}-modal">
                                            <i class="fas fa-barcode"></i> {{ __('employee.orders.actions.scan_item') }}
                                        </button>
                                    </td>
                                </tr>

                                @push('modals')
                                    <div class="modal fade" id="scan-item-{{ $item->id }}-modal" tabindex="-1" aria-labelledby="show-modal-label" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="show-modal-label">
                                                        {{ $item->product->name }}
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>

                                                <div class="modal-body">
                                                    <livewire:employee.orders.scan-order-item :item="$item" :key="$item->id" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endpush
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</div>
