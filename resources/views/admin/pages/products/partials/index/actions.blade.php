{{-- <livewire:admin.products.export-products /> --}}

{{-- @if(can('products.edit'))
    <div class="btn-group">
        <button type="button" class="btn btn-secondary fw-semibold dropdown-toggle position-relative" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-briefcase"></i>
            {{ __('globals.services') }}
        </button>

        <ul class="dropdown-menu">
            @if(can('products.edit'))
                <li>
                    <a href="javascript:void(0)" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#pull-products-modal">
                        <i class="fas fa-download me-1"></i> <span class="me-3">{{ __('admin.products.pull_form.pull_products') }}</span>
                    </a>
                </li>
            @endif
        </ul>
    </div>
@endif --}}

<x-admin.actions.filter-drawer>
    <livewire:admin.products.filter-products />
</x-admin.actions.filter-drawer>
