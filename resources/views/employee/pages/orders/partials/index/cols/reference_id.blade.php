<span
    class="id-wrapper"
    data-id="{{ $order->id }}"
    data-show-url="{{ route('employee.orders.show', $order->id) }}"
>
    <a href="{{ $order->admin_url }}" target="_blank">
        {{ $order->reference_id }}
    </a>
</span>
