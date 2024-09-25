<div>
    @if($executedItems->count())
        <div class="mb-5">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">تم التأكيد ({{ $executedItems->count() }})</h3>
                </div>

                <div class="card-body">
                    <div class="order-products">
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
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($toExecuteItems->count())
        <div class="mb-5">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">قيد التأكيد ({{ $toExecuteItems->count() }})</h3>
                </div>

                <div class="card-body">
                    <div class="order-products">
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

                                    @if($variant && filled($variant->barcode))
                                        <tr wire:key="to-execute-item-{{ $item->id }}">
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
                                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#scan-item-{{ $item->id }}-modal" wire:key="scan-{{ $item->id }}">
                                                    <i class="fas fa-barcode"></i> {{ __('employee.orders.actions.scan_item') }}
                                                </button>

                                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#transfer-item-{{ $item->id }}-modal" wire:key="transfer-{{ $item->id }}">
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
                                            <td colspan="4">
                                                <div class="alert alert-danger text-danger text-center fw-bold">
                                                    <p class="mb-0">
                                                        {{ __('employee.orders.errors.no_barcode_for_this_product') }}
                                                    </p>
                                                </div>
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
    @endif

    @if($quantityIssuesItems->count())
        <div class="mb-5">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">مشاكل كميات ({{ $quantityIssuesItems->count() }})</h3>
                </div>

                <div class="card-body">
                    <div class="order-products">
                        <table class="table table-row-bordered">
                            <thead>
                                <th class="fw-bold">{{ __('employee.products.attributes.image') }}</th>
                                <th class="fw-bold">{{ __('employee.products.attributes.name') }}</th>
                                <th class="fw-bold">{{ __('employee.products.attributes.variant') }}</th>
                                <th class="fw-bold">{{ __('employee.products.attributes.barcode') }}</th>
                                <th class="fw-bold">{{ __('employee.orders.items.attributes.quantity') }}</th>
                                <th class="fw-bold">{{ __('employee.orders.items.attributes.executed_quantity') }}</th>
                                <th class="fw-bold">{{ __('employee.orders.items.attributes.employee_note') }}</th>
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
                                            {{ filled($item->employee_note) ? $item->employee_note : '---' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
