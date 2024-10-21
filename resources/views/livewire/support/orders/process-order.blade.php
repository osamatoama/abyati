<div>
    @if($executedItems->count())
        <div class="mb-5">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">تم التأكيد ({{ $executedItems->count() }})</h3>
                </div>

                <div class="card-body">
                    <div class="order-products">
                        <div class="table-responsive">
                            <table class="table table-row-bordered">
                                <thead>
                                    <th class="fw-bold">{{ __('support.products.attributes.image') }}</th>
                                    <th class="fw-bold">{{ __('support.products.attributes.name') }}</th>
                                    <th class="fw-bold">{{ __('support.products.attributes.variant') }}</th>
                                    <th class="fw-bold">{{ __('support.products.attributes.barcode') }}</th>
                                    <th class="fw-bold">{{ __('support.orders.items.attributes.quantity') }}</th>
                                    <th class="fw-bold">{{ __('support.orders.items.attributes.executed_quantity') }}</th>
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
                                            <td>{{ $item->barcode ?? '---' }}</td>
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
                        <div class="table-responsive">
                            <table class="table table-row-bordered">
                                <thead>
                                    <th class="fw-bold">{{ __('support.products.attributes.image') }}</th>
                                    <th class="fw-bold">{{ __('support.products.attributes.name') }}</th>
                                    <th class="fw-bold">{{ __('support.products.attributes.variant') }}</th>
                                    <th class="fw-bold">{{ __('support.products.attributes.barcode') }}</th>
                                    <th class="fw-bold">{{ __('support.orders.items.attributes.quantity') }}</th>
                                    <th class="fw-bold">{{ __('support.orders.items.attributes.executed_quantity') }}</th>
                                    <th class="fw-bold">{{ __('support.orders.items.attributes.employee_note') }}</th>
                                    <th></th>
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
                                            <td>{{ $item->barcode ?? '---' }}</td>
                                            <td>
                                                {{ $item->quantity }}
                                            </td>
                                            <td>
                                                {{ $item->executed_quantity }}
                                            </td>
                                            <td>
                                                {{ filled($item->employeeNote?->content) ? $item->employeeNote->content : '---' }}
                                            </td>
                                            <td>
                                                <livewire:support.orders.complete-order-item :$item :key="'complete-' . $item->id" />
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
