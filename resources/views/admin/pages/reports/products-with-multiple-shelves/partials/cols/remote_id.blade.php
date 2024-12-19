<span
    class="id-wrapper"
    data-id="{{ $product->remote_id }}"
    {{-- data-show-url="{{ route('admin.orders.show', $product->order->id) }}"
    data-id-color="{{ getStoreIdColor($product->order->store_id) }}" --}}
>
    {{ $product->remote_id }}
</span>
