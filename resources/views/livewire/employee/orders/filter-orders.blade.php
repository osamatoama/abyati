<form wire:submit.prevent="apply">
    <div class="mb-10" wire:ignore>
        <label class="form-label">{{ __('employee.orders.attributes.store') }}</label>

        <select id="filter-store_ids" class="form-control" data-control="select2" data-placeholder="{{ __('globals.select_store') }}" multiple>
            @foreach($stores as $storeId => $storeName)
                <option value="{{ $storeId }}">{{ $storeName }}</option>
            @endforeach
        </select>

        @error('store_ids') <span class="form-input-error text-danger"></span> @enderror
    </div>

    <div class="mb-10" wire:ignore>
        <div class="col-12 mb-5">
            <label class="form-label">{{ __('employee.orders.attributes.date') }}</label>

            <input id="filter-date" type="text" class="form-control" wire:model="date" />

            @error('from_date') <span class="form-input-error text-danger">{{ $message }}</span> @enderror
            @error('to_date') <span class="form-input-error text-danger">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="mb-10" wire:ignore>
        <label class="form-label">{{ __('employee.orders.attributes.completion_status') }}</label>

        <select id="filter-completion_statuses" class="form-control" data-control="select2" multiple>
            @foreach(\App\Enums\OrderCompletionStatus::toSelectArray() as $key => $name)
                <option value="{{ $key }}">{{ $name }}</option>
            @endforeach
        </select>

        @error('completion_statuses') <span class="form-input-error text-danger"></span> @enderror
    </div>

    <div class="mb-10">
        <label class="form-label">{{ __('employee.orders.attributes.assign_status') }}</label>

        <select wire:model="is_assigned" wire:change="apply" class="form-control">
            <option value="">{{ __('employee.orders.assign_statuses.all') }}</option>
            <option value="1">{{ __('employee.orders.assign_statuses.assigned_to_me') }}</option>
            <option value="0">{{ __('employee.orders.assign_statuses.not_assigned') }}</option>
        </select>

        @error('is_assigned') <span class="form-input-error text-danger"></span> @enderror
    </div>

    <div class="d-flex justify-content-end">
        <a wire:click="resetFilters" class="btn btn-sm btn-light-danger btn-active-danger me-2" data-kt-menu-dismiss="true">
            {{ __('globals.reset_filters') }}
        </a>
        <button type="submit" class="btn btn-sm btn-primary" data-kt-menu-dismiss="true">
            {{ __("globals.apply") }}
        </button>
    </div>
</form>

@script
    <script>
        flatpickr($('#filter-date'), {
            altInput: true,
            altFormat: "Y-m-d",
            dateFormat: "Y-m-d",
            mode: "range",
            locale: getCurrentLang(),
            disable: [
                function(date) {
                    return date > new Date
                }
            ],
        })

        Livewire.on('order-filters-mounted', (event) => {
            setTimeout(() => {
                $('#filter-store_ids').val(@this.get('store_ids')).trigger('change')
                $('#filter-completion_statuses').val(@this.get('completion_statuses')).trigger('change')
            }, 1000);
        })

        Livewire.on('order-filters-reset', (event) => {
            $('#filter-store_ids').val(null).trigger('change')
            $('#filter-completion_statuses').val(null).trigger('change')
        })

        $('#filter-date').on('change', function() {
            @this.apply()
        })

        $('#filter-store_ids').on('change', function() {
            @this.set('store_ids', $('#filter-store_ids').val())
            @this.apply()
        })

        $('#filter-completion_statuses').on('change', function() {
            @this.set('completion_statuses', $('#filter-completion_statuses').val())
            @this.apply()
        })
    </script>
@endscript
