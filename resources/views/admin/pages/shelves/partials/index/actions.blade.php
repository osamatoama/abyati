@if(can('shelves.edit'))
    <div class="d-flex align-items-center position-relative">
        <a href="#" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#create-modal">
            <i class="fas fa-plus-circle"></i> {{ __('globals.add') }}
        </a>
    </div>
@endif


@if(can('shelves.edit'))
    <div class="btn-group">
        <button type="button" class="btn fw-bold btn-info dropdown-toggle position-relative" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-file-excel"></i>
            {{ __('admin.shelves.actions.import_products') }}
        </button>

        <ul class="dropdown-menu">
            <li>
                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#import-warehouse-modal">
                    <i class="fas fa-warehouse me-1"></i> <span class="me-3">{{ __('admin.shelves.import_options.warehouse') }}</span>
                </a>
            </li>
            <li>
                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#import-aisle-modal">
                    <i class="fas fa-dolly me-1"></i> <span class="me-3">{{ __('admin.shelves.import_options.aisle') }}</span>
                </a>
            </li>
            <li>
                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#import-shelf-modal">
                    <i class="fas fa-boxes-stacked me-1"></i> <span class="me-3">{{ __('admin.shelves.import_options.shelf') }}</span>
                </a>
            </li>
        </ul>
    </div>
@endif

<x-admin.actions.filter-drawer>
    <livewire:admin.shelves.filter-shelves />
</x-admin.actions.filter-drawer>
