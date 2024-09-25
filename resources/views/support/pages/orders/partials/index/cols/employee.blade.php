@if($order->employee)
    {{ $order->employee->name }}
@else
    ---
@endif
