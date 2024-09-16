<div class="actions-wrapper">
    @if($order->isNotAssigned())
        <button
            data-action="{{ route('employee.orders.assign', $order) }}"
            class="assign-btn btn btn-outline btn-outline-info btn-sm"
            data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('employee.orders.actions.assign') }}"
        >
            <i class="fas fa-user-plus pe-0"></i>
        </button>
    @endif

    @if($order->isAssignedToMe())
        <a
            href="{{ route('employee.orders.process', $order) }}"
            class="process-btn btn btn-outline btn-outline-success btn-sm"
            data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('employee.orders.actions.process') }}"
        >
            <i class="fas fa-cart-shopping pe-0"></i>
        </a>
    @endif
</div>
