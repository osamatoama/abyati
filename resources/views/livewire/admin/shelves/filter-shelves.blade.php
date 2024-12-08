<form wire:submit.prevent="apply">
    <div class="mb-10" wire:ignore>
        <label class="form-label">{{ __('admin.shelves.attributes.warehouse') }}</label>

        <select id="filter-warehouse_ids" class="form-control" data-control="select2" data-placeholder="{{ __('globals.select_warehouse') }}" multiple>
            @foreach($warehouses as $warehouseId => $warehouseName)
                <option value="{{ $warehouseId }}">{{ $warehouseName }}</option>
            @endforeach
        </select>

        @error('warehouse_ids') <span class="form-input-error text-danger"></span> @enderror
    </div>

    <div class="d-flex justify-content-end">
        <a wire:click="resetFilters" class="btn btn-sm btn-light-danger btn-active-danger me-2" data-kt-menu-dismiss="true">
            {{ __('globals.reset_filters') }}
        </a>
    </div>
</form>

@script
    <script>
        Livewire.on('shelf-filters-mounted', (event) => {
            setTimeout(() => {
                $('#filter-warehouse_ids').val(@this.get('warehouse_ids')).trigger('change')
            }, 1000);
        })

        Livewire.on('shelf-filters-reset', (event) => {
            $('#filter-warehouse_ids').val(null).trigger('change')
        })

        $('#filter-warehouse_ids').on('change', function() {
            console.log($('#filter-warehouse_ids').val())
            @this.set('warehouse_ids', $('#filter-warehouse_ids').val())
            @this.apply()
        })
    </script>
@endscript
