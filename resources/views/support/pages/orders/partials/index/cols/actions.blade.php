<div class="actions-wrapper">
    @if($order->isNotAssigned())
        <button
            data-action="{{ route('support.orders.assign', $order) }}"
            class="assign-btn btn btn-outline btn-outline-info btn-sm"
            data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('support.orders.actions.assign') }}"
        >
            <i class="fas fa-user-plus pe-0"></i>
        </button>
    @endif

    @if($order->isAssignedToMe() && ! $order->isExecuted())
        <a
            href="{{ route('support.orders.process', $order) }}"
            class="process-btn btn btn-outline btn-outline-success btn-sm"
            data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('support.orders.actions.process') }}"
        >
            <i class="fas fa-cart-shopping pe-0"></i>
        </a>

        <button
            data-action="{{ route('support.orders.unassign', $order) }}"
            data-confirm-message="{{ __('support.orders.messages.unassign_confirm') }}"
            data-confirm-title="{{ __('support.orders.actions.unassign') }}"
            class="unassign-btn btn btn-outline btn-outline-danger btn-sm ms-1"
            data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('support.orders.actions.unassign') }}"
        >
            <i class="fas fa-user-minus pe-0"></i>
        </button>
    @endif
</div>
