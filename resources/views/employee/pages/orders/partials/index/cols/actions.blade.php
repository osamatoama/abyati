<div class="actions-wrapper d-flex">
    {{-- <button
        data-show-url="{{ route('employee.orders.show', $order->id) }}"
        class="show-btn btn btn-outline btn-outline-primary btn-sm mb-1 me-1"
        data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('employee.orders.actions.show_details') }}"
    >
        <i class="fas fa-eye pe-0"></i>
    </button> --}}

    @if($order->isNotAssigned())
        <button
            data-action="{{ route('employee.orders.assign', $order) }}"
            class="assign-btn btn btn-outline btn-outline-info btn-sm mb-1 me-1"
            data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('employee.orders.actions.assign') }}"
        >
            <i class="fas fa-user-plus pe-0"></i>
        </button>
    @endif

    @if($order->isAssignedToMe() && ! $order->isExecuted())
        <a
            href="{{ route('employee.orders.process', $order) }}"
            class="process-btn btn btn-outline btn-outline-success btn-sm mb-1 me-1"
            data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('employee.orders.actions.process') }}"
        >
            <i class="fas fa-cart-shopping pe-0"></i>
        </a>

        <button
            data-action="{{ route('employee.orders.unassign', $order) }}"
            data-confirm-message="{{ __('employee.orders.messages.unassign_confirm') }}"
            data-confirm-title="{{ __('employee.orders.actions.unassign') }}"
            class="unassign-btn btn btn-outline btn-outline-danger btn-sm mb-1 me-1"
            data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('employee.orders.actions.unassign') }}"
        >
            <i class="fas fa-user-minus pe-0"></i>
        </button>
    @endif
</div>
