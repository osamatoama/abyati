@if(can('shelves.edit'))
    <div class="d-flex align-items-center position-relative">
        <a href="#" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#import-modal">
            <i class="fas fa-file-excel"></i> {{ __('admin.shelves.actions.import') }}
        </a>
    </div>
@endif

<x-admin.actions.filter-drawer>
    <livewire:admin.shelves.filter-shelves />
</x-admin.actions.filter-drawer>
