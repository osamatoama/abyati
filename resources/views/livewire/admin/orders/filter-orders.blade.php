<form wire:submit.prevent="apply">
    <div class="mb-10" wire:ignore>
        <label class="form-label">{{ __('admin.orders.attributes.store') }}</label>

        <select id="filter-store_ids" class="form-control" data-control="select2" data-placeholder="{{ __('globals.select_store') }}" multiple>
            @foreach($stores as $storeId => $storeName)
                <option value="{{ $storeId }}">{{ $storeName }}</option>
            @endforeach
        </select>

        @error('store_ids') <span class="form-input-error text-danger"></span> @enderror
    </div>

    <div class="mb-10" wire:ignore>
        <div class="col-12 mb-5">
            <label class="form-label">{{ __('admin.orders.attributes.date') }}</label>

            <input id="filter-date" type="text" class="form-control" wire:model="date" />

            @error('from_date') <span class="form-input-error text-danger">{{ $message }}</span> @enderror
            @error('to_date') <span class="form-input-error text-danger">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="mb-10" wire:ignore>
        <label class="form-label">{{ __('admin.orders.attributes.completion_status') }}</label>

        <select id="filter-completion_statuses" class="form-control" data-control="select2" multiple>
            @foreach(\App\Enums\OrderCompletionStatus::toSelectArray() as $key => $name)
                <option value="{{ $key }}">{{ $name }}</option>
            @endforeach
        </select>

        @error('completion_statuses') <span class="form-input-error text-danger"></span> @enderror
    </div>

    <div class="mb-10">
        <label class="form-label">{{ __('admin.orders.attributes.assign_status') }}</label>

        <select wire:model="is_assigned" class="form-control">
            <option value="">{{ __('admin.orders.assign_statuses.all') }}</option>
            <option value="true">{{ __('admin.orders.assign_statuses.assigned') }}</option>
            <option value="false">{{ __('admin.orders.assign_statuses.not_assigned') }}</option>
        </select>

        @error('is_assigned') <span class="form-input-error text-danger"></span> @enderror
    </div>

    <div class="mb-10" wire:ignore>
        <label class="form-label">{{ __('admin.orders.attributes.employee') }}</label>

        <select id="filter-employee_ids" class="form-control" data-control="select2" data-placeholder="{{ __('globals.select_employee') }}" multiple>
            @foreach($employees as $employeeId => $employeeName)
                <option value="{{ $employeeId }}">{{ $employeeName }}</option>
            @endforeach
        </select>

        @error('employee_ids') <span class="form-input-error text-danger"></span> @enderror
    </div>

    <div class="d-flex justify-content-end">
        <a href="{{ route('admin.orders.index') }}"
            class="btn btn-sm btn-light btn-active-light-primary me-2" data-kt-menu-dismiss="true">
            {{ __("globals.reset") }}
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
                $('#filter-employee_ids').val(@this.get('employee_ids')).trigger('change')
                $('#filter-completion_statuses').val(@this.get('completion_statuses')).trigger('change')
            }, 1000);
        })

        $('#filter-store_ids').on('change', function() {
            @this.set('store_ids', $('#filter-store_ids').val())
        })

        $('#filter-completion_statuses').on('change', function() {
            @this.set('completion_statuses', $('#filter-completion_statuses').val())
        })

        $('#filter-employee_ids').on('change', function() {
            @this.set('employee_ids', $('#filter-employee_ids').val())
        })
    </script>
@endscript
