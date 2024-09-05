@if(filled($order->payment_method))
    {{ lang("orders.payment_methods.{$order->payment_method}") }}
@else
    ---
@endif
