@if(can('orders.edit'))
    <div class="btn-group">
        <button type="button" class="btn fw-bold btn-secondary dropdown-toggle position-relative" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-briefcase"></i>
            {{ __('globals.services') }}
        </button>

        <ul class="dropdown-menu">
            @if(can('orders.edit'))
                <li>
                    <a href="javascript:void(0)" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#pull-orders-modal">
                        <i class="fas fa-download me-1"></i> <span class="me-3">{{ __('admin.orders.pull_form.pull_orders') }}</span>
                    </a>
                </li>
            @endif
        </ul>
    </div>
@endif

<x-admin.actions.filter-drawer>
    <livewire:admin.orders.filter-orders />
</x-admin.actions.filter-drawer>
