<p class="order-date mb-0 text-nowrap">
    <span dir="ltr">{{ $order->date->format('Y-m-d') }}</span>
</p>
<p class="order-date mb-1 text-nowrap">
    <span dir="ltr">{{ $order->date->format('h:i a') }}</span>
</p>
<p class="order-date-diff mb-0 fst-italic text-muted">
    {{ $order->date->diffForHumans() }}
</p>
