<style>
    .fit-content-table {
        width: 100%;
        table-layout: auto;
    }

    .fit-content-table th {
        text-wrap: nowrap;
    }

    .fit-content-table td:last-child {
        width: 80%;
    }
</style>

<div class="card card-flush h-lg-100" id="kt_contacts_main">
    <div class="card-header" id="">
        <div class="card-title">
            <h2>#{{ $order->reference_id }}</h2>
        </div>
    </div>

    <div class="card-body pt-5">
        <div class="d-flex gap-7 align-items-center">
            <div class="d-flex flex-column gap-2">
                @if(filled($order->payment_method))
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-money-bill"></i>
                        <a class="text-muted text-hover-primary" dir="ltr">
                            {{ lang("orders.payment_methods.{$order->payment_method}") }}
                        </a>
                    </div>
                @endif

                <div class="d-flex align-items-center gap-2">
                    <i class="fas fa-stairs"></i>
                    <a href="#" class="text-muted text-hover-primary">{{ $order->status_name }}</a>
                </div>

                @if(filled($order->admin_url))
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-link"></i>
                        <a href="{{ $order->admin_url }}" class="text-muted text-hover-primary">{{ __('employee.orders.attributes.admin_url') }}</a>
                    </div>
                @endif

                @if(filled($order->customer_url))
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-up-right-from-square"></i>
                        <a href="{{ $order->customer_url }}" class="text-muted text-hover-primary">{{ __('employee.orders.attributes.customer_url') }}</a>
                    </div>
                @endif
            </div>
        </div>

        <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x fs-6 fw-semibold mt-6 mb-8 gap-2" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link text-active-primary d-flex align-items-center pb-4 active" data-bs-toggle="tab" href="#order-details-items" aria-selected="true" role="tab">
                    <i class="fas fa-cart-shopping fs-4 me-2"></i>
                    {{ __('employee.orders.attributes.items') }}
                </a>
            </li>

            <li class="nav-item" role="presentation">
                <a class="nav-link text-active-primary d-flex align-items-center pb-4" data-bs-toggle="tab" href="#order-details-customer" aria-selected="true" role="tab">
                    <i class="fas fa-user fs-4 me-2"></i>
                    {{ __('employee.orders.attributes.customer') }}
                </a>
            </li>

            <li class="nav-item" role="presentation">
                <a class="nav-link text-active-primary d-flex align-items-center pb-4" data-bs-toggle="tab" href="#order-details-calculations" aria-selected="true" role="tab">
                    <i class="fas fa-calculator fs-4 me-2"></i>
                    {{ __('employee.orders.calculations') }}
                </a>
            </li>

            <li class="nav-item" role="presentation">
                <a class="nav-link text-active-primary d-flex align-items-center pb-4" data-bs-toggle="tab" href="#order-details-history" aria-selected="true" role="tab">
                    <i class="fas fa-clock-rotate-left fs-4 me-2"></i>
                    {{ __('employee.orders.history.title') }}
                </a>
            </li>

            <li class="nav-item" role="presentation">
                <a class="nav-link text-active-primary d-flex align-items-center pb-4" data-bs-toggle="tab" href="#order-details-address" aria-selected="true" role="tab">
                    <i class="fas fa-location-dot fs-4 me-2"></i>
                    {{ $order->isPickup() ? __('employee.orders.address.attributes.pickup_address') : __('employee.orders.address.attributes.shipping_address') }}
                </a>
            </li>
        </ul>

        <div class="tab-content" id="">
            <div class="tab-pane fade show active" id="order-details-items" role="tabpanel">
                <table class="table table-row-bordered">
                    <thead>
                        <tr>
                            <th>{{ __('employee.orders.items.attributes.product') }}</th>
                            <th>{{ __('employee.orders.items.attributes.barcode') }}</th>
                            <th>{{ __('employee.orders.items.attributes.quantity') }}</th>
                            <th>{{ __('employee.orders.items.attributes.unit_price') }}</th>
                            <th>{{ __('employee.orders.items.attributes.total') }}</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($order->items as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center mb-1 p-1">
                                        @if(filled($item->product->main_image))
                                            <a href="{{ $item->product->main_image }}" target="_blank" class="me-3">
                                                <img src="{{ $item->product->main_image }}" alt="{{ $item->product->name }}" width="100" height="100">
                                            </a>
                                        @endif

                                        <div>
                                            {{ $item->product->name }}

                                            @if($item->trashed())
                                                <span class="badge badge-danger ms-1">{{ __('globals.deleted') }}</span>
                                            @endif
                                        </div>

                                        @if($item->variant?->optionValues?->isNotEmpty())
                                            <div>
                                                ({{ $item->variant->optionValues->map(fn($optionValue) => $optionValue->option->name . ': ' . $optionValue->name)->implode(' - ') }})
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    {{ $item->barcode ?? '---' }}
                                </td>
                                <td>
                                    {{ $item->quantity }}
                                </td>
                                <td>
                                    {{ round($item->unit_price) }}
                                </td>
                                <td>
                                    {{ round($item->total) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="tab-pane fade" id="order-details-customer" role="tabpanel">
                <table class="table fit-content-table">
                    <tbody>
                        <tr>
                            <th class="fw-semibold">{{ __('employee.customers.attributes.name') }}</th>
                            <td>{{ $order->customer_name }}</td>
                        </tr>

                        <tr>
                            <th class="fw-semibold">{{ __('employee.customers.attributes.email') }}</th>
                            <td>{{ $order->customer['email'] ?? '---' }}</td>
                        </tr>

                        <tr>
                            <th class="fw-semibold">{{ __('employee.customers.attributes.mobile') }}</th>
                            <td>
                                <span dir="ltr">
                                    {{ $order->customer_phone ?? '---' }}
                                </span>
                            </td>
                        </tr>

                        <tr>
                            <th class="fw-semibold">{{ __('employee.customers.attributes.city') }}</th>
                            <td>{{ $order->customer['city'] ?? '---' }}</td>
                        </tr>

                        <tr>
                            <th class="fw-semibold">{{ __('employee.customers.attributes.country') }}</th>
                            <td>{{ $order->customer['country'] ?? '---' }}</td>
                        </tr>

                        <tr>
                            <th class="fw-semibold">{{ __('employee.customers.attributes.currency') }}</th>
                            <td>{{ $order->customer['currency'] ?? '---' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="tab-pane fade" id="order-details-calculations" role="tabpanel">
                <table class="table fit-content-table">
                    <tbody>
                        <tr>
                            <th class="fw-semibold">{{ __('employee.orders.attributes.sub_total') }}</th>
                            <td>{{ round($order->amounts['sub_total']['amount'], 2) . ' ' . lang("currency.{$order->amounts['sub_total']['currency']}") }}</td>
                        </tr>

                        <tr>
                            <th class="fw-semibold">{{ __('employee.orders.attributes.shipping_cost') }}</th>
                            <td>{{ round($order->amounts['shipping_cost']['amount'], 2) . ' ' . lang("currency.{$order->amounts['shipping_cost']['currency']}") }}</td>
                        </tr>

                        <tr>
                            <th class="fw-semibold">{{ __('employee.orders.attributes.cash_on_delivery') }}</th>
                            <td>{{ round($order->amounts['cash_on_delivery']['amount'], 2) . ' ' . lang("currency.{$order->amounts['cash_on_delivery']['currency']}") }}</td>
                        </tr>

                        <tr>
                            <th class="fw-semibold">{{ __('employee.orders.attributes.tax') }}</th>
                            <td>{{ round($order->amounts['tax']['amount']['amount'], 2) . ' ' . lang("currency.{$order->amounts['tax']['amount']['currency']}") }}</td>
                        </tr>

                        <tr>
                            <th class="fw-semibold">{{ __('employee.orders.attributes.total') }}</th>
                            <td>{{ round($order->amounts['total']['amount'], 2) . ' ' . lang("currency.{$order->amounts['total']['currency']}") }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="tab-pane fade" id="order-details-history" role="tabpanel">
                <table class="table">
                    <thead class="fw-bold">
                        <tr>
                            <th>{{ __('employee.orders.history.attributes.status') }}</th>
                            <th>{{ __('employee.orders.history.attributes.note') }}</th>
                            <th>{{ __('employee.orders.history.attributes.date') }}</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($order->histories ?? [] as $history)
                            <tr class="border-top">
                                <td>{{ $history->status->name }}</td>
                                <td>{{ filled($history->note) ? $history->note : '-----' }}</td>
                                <td>
                                    <span dir="ltr">
                                        {{ $history->date->format('Y-m-d h:i a') }}
                                    </span>
                                    <br>
                                    <span class="badge badge-sm badge-primary">
                                        {{ $history->date->diffForHumans() }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr class="border-top">
                                <td colspan="4" class="text-center">
                                    {{ __('globals.no_data_found') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="tab-pane fade" id="order-details-address" role="tabpanel">
                @if($order->address['address_line'] ?? false)
                    <p class="fs-6">
                        {!!
                            str($order->address['address_line'])
                                ->replace('،,', ',')
                                ->replace(',,', ',')
                                ->replace(['،', ','], '<br>')
                        !!}
                    </p>
                @else
                    <p class="text-muted">
                        {{ __('employee.orders.messages.no_shipping_address') }}
                    </p>
                @endif
            </div>
        </div>
    </div>
</div>
