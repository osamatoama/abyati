<span
    class="id-wrapper"
    data-id="{{ $execution->order->id }}"
    {{-- data-show-url="{{ route('admin.orders.show', $execution->order->id) }}"
    data-id-color="{{ getStoreIdColor($execution->order->store_id) }}" --}}
>
    <a href="{{ $execution->order->admin_url }}" target="_blank">
        {{ $execution->order->reference_id }}
    </a>
</span>
