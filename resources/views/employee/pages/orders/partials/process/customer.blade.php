<div class="mb-5">
    <div class="card">
        <div class="card-body">
            <table class="table fit-content-table">
                <tbody>
                    <tr>
                        <th class="fw-semibold">{{ __('employee.customers.attributes.name') }}</th>
                        <td>{{ $order->customer_name }}</td>
                    </tr>

                    <tr>
                        <th class="fw-semibold">{{ __('employee.customers.attributes.email') }}</th>
                        <td>
                            @if(! empty($order->customer['email']))
                                {{ $order->customer['email'] }}

                                <span class="copy-email-btn cursor-pointer ms-1" onclick="copyToClipboardWithSuccessToast('{{ $order->customer['email'] }}')">
                                    <i class="fas fa-clipboard" style="font-size: 1.25rem;"></i>
                                </span>

                                <span class="customer-mail-btn cursor-pointer ms-1">
                                    <a href="mailto:{{ $order->customer['email'] }}">
                                        <i class="fas fa-envelope text-primary" style="font-size: 1.25rem;"></i>
                                    </a>
                                </span>
                            @else
                                ---
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="fw-semibold">{{ __('employee.customers.attributes.mobile') }}</th>
                        <td>
                            @if(filled($order->customer_phone))
                                <span dir="ltr">
                                    {{ $order->customer_phone }}
                                </span>

                                <span class="copy-phone-btn cursor-pointer ms-1" onclick="copyToClipboardWithSuccessToast('{{ $order->customer_phone }}')">
                                    <i class="fas fa-clipboard" style="font-size: 1.25rem;"></i>
                                </span>

                                <span class="customer-phone-btn cursor-pointer ms-1">
                                    <a href="tel:{{ $order->customer_phone }}">
                                        <i class="fas fa-phone text-primary" style="font-size: 1.25rem;"></i>
                                    </a>
                                </span>

                                <span class="customer-whatsapp-btn cursor-pointer ms-1">
                                    <a href="https://wa.me/{{ $order->customer_phone }}" target="_blank">
                                        <i class="fab fa-whatsapp fw-semibold text-success" style="font-size: 1.5rem;"></i>
                                    </a>
                                </span>
                            @else
                                ---
                            @endif
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

                    <tr>
                        <th class="fw-semibold">
                            {{ $order->isPickup() ? __('employee.orders.address.attributes.pickup_address') : __('employee.orders.address.attributes.shipping_address') }}
                        </th>
                        <td>
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
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>