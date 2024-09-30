<form wire:submit.prevent="apply">
    <div class="row">
        <div class="col-12 col-sm-6 col-md-4 mb-10" wire:ignore>
            <label class="form-label">{{ __('admin.reports.employee_performance.filters.employee_id') }}</label>

            <select id="filter-employee_id" class="form-control" data-control="select2">
                <option value="">---</option>

                @foreach($employees as $employeeId => $employeeName)
                    <option value="{{ $employeeId }}">{{ $employeeName }}</option>
                @endforeach
            </select>

            @error('employee_id') <span class="form-input-error text-danger"></span> @enderror
        </div>

        <div class="col-12 col-sm-6 col-md-4 mb-10" wire:ignore>
            <label class="form-label">{{ __('globals.date') }}</label>

            <input id="filter-date" type="text" class="form-control" wire:model="date" />

            @error('from_date') <span class="form-input-error text-danger">{{ $message }}</span> @enderror
            @error('to_date') <span class="form-input-error text-danger">{{ $message }}</span> @enderror
        </div>
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

        Livewire.on('report-filters-mounted', (event) => {
            setTimeout(() => {
                $('#filter-employee_id').val(@this.get('employee_id')).trigger('change')
            }, 1000);
        })

        Livewire.on('report-filters-reset', (event) => {
            $('#filter-employee_id').val(null).trigger('change')
        })

        $('#filter-employee_id').on('change', function() {
            @this.set('employee_id', $('#filter-employee_id').val())
            @this.apply()
        })
    </script>
@endscript
