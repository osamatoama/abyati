@if(can('shelves.edit'))
    <div class="d-flex align-items-center position-relative">
        <a href="#" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#create-modal">
            <i class="fas fa-plus-circle"></i> {{ __('globals.add') }}
        </a>
    </div>
@endif

<x-employee.actions.filter-drawer>
    <livewire:employee.shelves.filter-shelves />
</x-employee.actions.filter-drawer>
