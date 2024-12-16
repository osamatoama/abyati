<div>
    @if($confirmedProducts->count())
        <div class="mb-5">
            <div class="card execution-card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('employee.stocktakings.process_statuses.confirmed') }} ({{ $confirmedProducts->count() }})</h3>
                </div>

                <div class="card-body">
                    <div class="order-products">
                        <div class="table-responsive">
                            <table class="table table-row-bordered">
                                <thead>
                                    <th class="fw-bold text-nowrap">{{ __('employee.products.attributes.image') }}</th>
                                    <th class="fw-bold text-nowrap">{{ __('employee.products.attributes.name') }}</th>
                                    <th class="fw-bold text-nowrap">{{ __('employee.products.attributes.barcode') }}</th>
                                    <th class="fw-bold text-nowrap">{{ __('employee.products.attributes.price') }}</th>
                                    <th class="fw-bold text-nowrap">{{ __('employee.products.attributes.quantity') }}</th>
                                </thead>

                                <tbody>
                                    @foreach($confirmedProducts as $product)
                                        <tr>
                                            <td>
                                                <img src="{{ $product->main_image }}" alt="{{ $product->name }}" class="img-fluid" style="max-width: 50px;">
                                            </td>
                                            <td>
                                                <div class="product-name">
                                                    {{ $product->name }}
                                                </div>
                                            </td>
                                            <td>
                                                <span dir="ltr">{{ $product->sku ?? '---' }}</span>
                                            </td>
                                            <td>
                                                {{ $product->price }}
                                            </td>
                                            <td>
                                                {{ $product->quantities->sum('quantity') }}
                                            </td>
                                            {{-- <td>
                                                {{ $item->executed_quantity }}

                                                @if($item->issue_quantity)
                                                    <span class="badge badge-danger ms-3">{{ __('employee.orders.process_statuses.quantity_issues') }}</span>
                                                @endif
                                            </td> --}}
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

    @if($issueProducts->count())
        <div class="mb-5">
            <div class="card execution-card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('employee.stocktakings.process_statuses.has_issues') }} ({{ $issueProducts->count() }})</h3>
                </div>

                <div class="card-body">
                    <div class="order-products">
                        <div class="table-responsive">
                            <table class="table table-row-bordered">
                                <thead>
                                    <th class="fw-bold text-nowrap">{{ __('employee.products.attributes.image') }}</th>
                                    <th class="fw-bold text-nowrap">{{ __('employee.products.attributes.name') }}</th>
                                    <th class="fw-bold text-nowrap">{{ __('employee.products.attributes.barcode') }}</th>
                                    <th class="fw-bold text-nowrap">{{ __('employee.products.attributes.price') }}</th>
                                    <th class="fw-bold text-nowrap">{{ __('employee.products.attributes.quantity') }}</th>
                                </thead>

                                <tbody>
                                    @foreach($issueProducts as $product)
                                        <tr>
                                            <td>
                                                <img src="{{ $product->main_image }}" alt="{{ $product->name }}" class="img-fluid" style="max-width: 50px;">
                                            </td>
                                            <td>
                                                <div class="product-name">
                                                    {{ $product->name }}
                                                </div>
                                            </td>
                                            <td>
                                                <span dir="ltr">{{ $product->sku ?? '---' }}</span>
                                            </td>
                                            <td>
                                                {{ $product->price }}
                                            </td>
                                            <td>
                                                {{ $product->quantities->sum('quantity') }}
                                            </td>
                                            {{-- <td>
                                                {{ $item->executed_quantity }}

                                                @if($item->issue_quantity)
                                                    <span class="badge badge-danger ms-3">{{ __('employee.orders.process_statuses.quantity_issues') }}</span>
                                                @endif
                                            </td> --}}
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

    {{-- @if($quantityIssuesItems->count())
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
    @endif --}}
</div>
