<div>
    @if($toExecuteItems->count())
        <div class="mb-5">
            <div class="card execution-card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('employee.orders.process_statuses.pending') }} ({{ $toExecuteItems->count() }})</h3>
                </div>

                <div class="card-body">
                    <div class="order-products">
                        <div class="table-responsive">
                            <table class="table table-row-bordered">
                                <thead>
                                    <th class="fw-bold text-nowrap">{{ __('employee.products.attributes.image') }}</th>
                                    <th class="fw-bold text-nowrap">{{ __('employee.products.attributes.shelf') }}</th>
                                    <th class="fw-bold text-nowrap">{{ __('employee.products.attributes.name') }}</th>
                                    <th class="fw-bold text-nowrap">{{ __('employee.products.attributes.barcode') }}</th>
                                    <th class="fw-bold text-nowrap">{{ __('employee.orders.items.attributes.quantity') }}</th>
                                    <th class="fw-bold text-nowrap">{{ __('employee.orders.items.attributes.executed_quantity') }}</th>
                                    <th></th>
                                </thead>

                                <tbody>
                                    @foreach(sortOrderItemsByShelves($toExecuteItems) as $item)
                                        @php
                                            $product = $item->product;
                                            $variant = $item->variant;
                                        @endphp

                                        @if(filled($item->barcode))
                                            <tr wire:key="to-execute-item-{{ $item->id }}">
                                                <td>
                                                    <img src="{{ $product->main_image }}" alt="{{ $product->name }}" class="img-fluid" style="max-width: 50px;">
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column gap-2 align-items-center">
                                                        @forelse ($item->product->shelves as $shelf)
                                                            <span class="badge badge-secondary">{{ $shelf->descriptive_name }}</span>
                                                        @empty
                                                            ---
                                                        @endforelse
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="product-name">
                                                        {{ $product->name }}
                                                    </div>

                                                    @if($variant?->optionValues?->isNotEmpty())
                                                        <div class="product-variant">
                                                            {{ $variant->optionValues->map(fn($optionValue) => $optionValue->option->name . ': ' . $optionValue->name)->implode(' - ') }}
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span dir="ltr">{{ $item->masked_barcode ?? '---' }}</span>
                                                </td>
                                                <td>
                                                    {{ $item->quantity }}
                                                </td>
                                                <td>
                                                    {{ $item->executed_quantity }}
                                                </td>
                                                <td class="text-nowrap">
                                                    <button class="btn btn-sm btn-primary text-nowrap" data-bs-toggle="modal" data-bs-target="#scan-item-{{ $item->id }}-modal" wire:key="scan-{{ $item->id }}">
                                                        <i class="fas fa-barcode"></i> {{ __('employee.orders.actions.scan_item') }}
                                                    </button>

                                                    <button class="btn btn-sm btn-warning text-nowrap" data-bs-toggle="modal" data-bs-target="#transfer-item-{{ $item->id }}-modal" wire:key="transfer-{{ $item->id }}">
                                                        <i class="fas fa-headphones"></i> {{ __('employee.orders.actions.transfer_to_support') }}
                                                    </button>
                                                </td>
                                            </tr>
                                        @else
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
                                                <td colspan="3">
                                                    <div class="alert alert-danger text-danger text-center fw-bold">
                                                        <p class="mb-0">
                                                            {{ __('employee.orders.errors.no_barcode_for_this_product') }}
                                                        </p>
                                                    </div>
                                                </td>
                                                <td>
                                                    <button class="btn btn-sm btn-warning text-nowrap" data-bs-toggle="modal" data-bs-target="#transfer-item-{{ $item->id }}-modal" wire:key="transfer-{{ $item->id }}">
                                                        <i class="fas fa-headphones"></i> {{ __('employee.orders.actions.transfer_to_support') }}
                                                    </button>
                                                </td>
                                            </tr>
                                        @endif

                                        @push('modals')
                                            <livewire:employee.orders.scan-order-item :$item :key="'scan-' . $item->id" />

                                            <livewire:employee.orders.transfer-order-item-to-support :$item :key="'transfer-' . $item->id" />
                                        @endpush
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($executedItems->count())
        <div class="mb-5">
            <div class="card execution-card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('employee.orders.process_statuses.completed') }} ({{ $executedItems->count() }})</h3>
                </div>

                <div class="card-body">
                    <div class="order-products">
                        <div class="table-responsive">
                            <table class="table table-row-bordered">
                                <thead>
                                    <th class="fw-bold text-nowrap">{{ __('employee.products.attributes.image') }}</th>
                                    <th class="fw-bold text-nowrap">{{ __('employee.products.attributes.name') }}</th>
                                    <th class="fw-bold text-nowrap">{{ __('employee.products.attributes.barcode') }}</th>
                                    <th class="fw-bold text-nowrap">{{ __('employee.orders.items.attributes.quantity') }}</th>
                                    <th class="fw-bold text-nowrap">{{ __('employee.orders.items.attributes.executed_quantity') }}</th>
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
                                            <td>
                                                <div class="product-name">
                                                    {{ $product->name }}
                                                </div>

                                                @if($variant?->optionValues?->isNotEmpty())
                                                    <div class="product-variant">
                                                        {{ $variant->optionValues->map(fn($optionValue) => $optionValue->option->name . ': ' . $optionValue->name)->implode(' - ') }}
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <span dir="ltr">{{ $item->masked_barcode ?? '---' }}</span>
                                            </td>
                                            <td>
                                                {{ $item->quantity }}
                                            </td>
                                            <td>
                                                {{ $item->executed_quantity }}

                                                @if($item->issue_quantity)
                                                    <span class="badge badge-danger ms-3">{{ __('employee.orders.process_statuses.quantity_issues') }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($quantityIssuesItems->count())
        <div class="mb-5">
            <div class="card execution-card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('employee.orders.process_statuses.quantity_issues') }} ({{ $quantityIssuesItems->count() }})</h3>
                </div>

                <div class="card-body">
                    <div class="order-products">
                        <div class="table-responsive">
                            <table class="table table-row-bordered">
                                <thead>
                                    <th class="fw-bold text-nowrap">{{ __('employee.products.attributes.image') }}</th>
                                    <th class="fw-bold text-nowrap">{{ __('employee.products.attributes.name') }}</th>
                                    <th class="fw-bold text-nowrap">{{ __('employee.products.attributes.barcode') }}</th>
                                    <th class="fw-bold text-nowrap">{{ __('employee.orders.items.attributes.quantity') }}</th>
                                    <th class="fw-bold text-nowrap">{{ __('employee.orders.items.attributes.executed_quantity') }}</th>
                                    <th class="fw-bold text-nowrap">{{ __('employee.orders.items.attributes.employee_note') }}</th>
                                </thead>

                                <tbody>
                                    @foreach($quantityIssuesItems as $item)
                                        @php
                                            $product = $item->product;
                                            $variant = $item->variant;
                                        @endphp

                                        <tr>
                                            <td>
                                                <img src="{{ $product->main_image }}" alt="{{ $product->name }}" class="img-fluid" style="max-width: 50px;">
                                            </td>
                                            <td>
                                                <div class="product-name">
                                                    {{ $product->name }}
                                                </div>

                                                @if($variant?->optionValues?->isNotEmpty())
                                                    <div class="product-variant">
                                                        {{ $variant->optionValues->map(fn($optionValue) => $optionValue->option->name . ': ' . $optionValue->name)->implode(' - ') }}
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <span dir="ltr">{{ $item->masked_barcode ?? '---' }}</span>
                                            </td>
                                            <td>
                                                {{ $item->quantity }}
                                            </td>
                                            <td>
                                                {{ $item->executed_quantity }}

                                                @if($item->issue_quantity)
                                                    <span class="badge badge-danger ms-3">{{ __('employee.orders.process_statuses.quantity_issues') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ filled($item->employeeNote?->content) ? $item->employeeNote->content : '---' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
