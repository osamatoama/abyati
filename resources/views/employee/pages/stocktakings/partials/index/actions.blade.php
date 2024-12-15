<div class="d-flex align-items-center position-relative">
    <a href="#" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#create-modal">
        <i class="fas fa-plus-circle"></i> {{ __('globals.add') }}
    </a>
</div>

{{-- <x-employee.actions.filter-drawer>
    <livewire:employee.stocktakings.filter-stocktakings />
</x-employee.actions.filter-drawer> --}}

@if($shelf)
    <div class="d-flex align-items-center position-relative">
        <a href="{{ route('employee.shelves.index') }}" class="btn btn-light">
            <i class="fas fa-arrow-left pe-0"></i> {{ __('globals.back') }}
        </a>
    </div>
@endif
