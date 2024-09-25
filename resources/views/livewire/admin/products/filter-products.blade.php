<form wire:submit.prevent="apply">
    <div class="mb-10" wire:ignore>
        <label class="form-label">{{ __('admin.products.attributes.store') }}</label>

        <select id="filter-store_ids" class="form-control" data-control="select2" data-placeholder="{{ __('globals.select_store') }}" multiple>
            @foreach($stores as $storeId => $storeName)
                <option value="{{ $storeId }}">{{ $storeName }}</option>
            @endforeach
        </select>

        @error('store_ids') <span class="form-input-error text-danger"></span> @enderror
    </div>

    <div class="d-flex justify-content-end">
        <a wire:click="resetFilters" class="btn btn-sm btn-light-danger btn-active-danger me-2" data-kt-menu-dismiss="true">
            {{ __("globals.reset_filters") }}
        </a>
    </div>
</form>

@script
    <script>
        Livewire.on('product-filters-mounted', (event) => {
            setTimeout(() => {
                $('#filter-store_ids').val(@this.get('store_ids')).trigger('change')
            }, 1000);
        })

        Livewire.on('product-filters-reset', (event) => {
            $('#filter-store_ids').val(null).trigger('change')
        })

        $('#filter-store_ids').on('change', function() {
            @this.set('store_ids', $('#filter-store_ids').val())
            @this.apply()
        })
    </script>
@endscript
