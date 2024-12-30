
{{-- <x-employee.actions.filter-drawer>
    <livewire:employee.stocktakings.filter-stocktakings />
</x-employee.actions.filter-drawer> --}}

@if($shelf)
    @if(! $shelf->hasPendingStocktaking())
        <div class="d-flex align-items-center position-relative">
            <a href="{{ route('employee.stocktakings.create', ['shelf_id' => $shelf->id]) }}" class="btn btn-success">
                <i class="fas fa-play"></i> {{ __('employee.stocktakings.actions.create') }}
            </a>
        </div>
    @endif

    <div class="d-flex align-items-center position-relative">
        <a href="{{ route('employee.shelves.products.sync', $shelf->id) }}" class="btn btn-primary">
            <i class="fas fa-rotate"></i> {{ __('employee.shelves.actions.sync_products') }}
        </a>
    </div>

    <div class="d-flex align-items-center position-relative">
        <a href="{{ route('employee.shelves.index') }}" class="btn btn-light">
            <i class="fas fa-arrow-left pe-0"></i> {{ __('globals.back') }}
        </a>
    </div>
@endif
