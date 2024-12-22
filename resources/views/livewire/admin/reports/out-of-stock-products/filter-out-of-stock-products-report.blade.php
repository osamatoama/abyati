{{-- <form wire:submit.prevent="apply"> --}}
<form>

    {{-- <div class="row">
        <div class="col-12 col-sm-6 col-md-4 mb-5" wire:ignore>
            <label class="form-label">{{ __('admin.reports.out_of_stock_products.filters.warehouse_id') }}</label>

            <select id="filter-warehouse_id" class="form-control" data-control="select2">
                <option value="" selected disabled>{{ __('globals.select') }}</option>

                @foreach($warehouses as $warehouseId => $warehouseName)
                    <option value="{{ $warehouseId }}">{{ $warehouseName }}</option>
                @endforeach
            </select>

            @error('warehouse_id') <span class="form-input-error text-danger"></span> @enderror
        </div>

        <div class="col-12 col-sm-6 col-md-4 mb-5" wire:ignore>
            <label class="form-label">{{ __('admin.reports.out_of_stock_products.filters.employee_id') }}</label>

            <select id="filter-employee_id" class="form-control" data-control="select2">
                <option value="" selected>{{ __('globals.select') }}</option>

                @foreach($employees as $employeeId => $employeeName)
                    <option value="{{ $employeeId }}">{{ $employeeName }}</option>
                @endforeach
            </select>

            @error('employee_id') <span class="form-input-error text-danger"></span> @enderror
        </div>

        <div class="col-12 col-sm-6 col-md-4 mb-5" wire:ignore>
            <label class="form-label">{{ __('admin.reports.out_of_stock_products.filters.aisle') }}</label>

            <select id="filter-aisle" class="form-control" data-control="select2">
                <option value="" selected disabled>{{ __('globals.select') }}</option>

                @foreach($aisles as $aisleKey => $aisleName)
                    <option value="{{ $aisleKey }}">{{ $aisleName }}</option>
                @endforeach
            </select>

            @error('aisle') <span class="form-input-error text-danger"></span> @enderror
        </div>

        <div class="col-12 col-sm-6 col-md-4 mb-5" wire:ignore>
            <label class="form-label">{{ __('admin.reports.out_of_stock_products.filters.shelf') }}</label>

            <select id="filter-shelf_id" class="form-control" data-control="select2">
                <option value="" selected disabled>{{ __('globals.select') }}</option>

                @foreach($shelves as $shelfId => $shelfName)
                    <option value="{{ $shelfId }}">{{ $shelfName }}</option>
                @endforeach
            </select>

            @error('shelf_id') <span class="form-input-error text-danger"></span> @enderror
        </div>
    </div> --}}

    <div class="row">
        <div class="col-12 col-sm-6 col-md-4 mb-5">
            <label class="form-label">{{ __('admin.reports.out_of_stock_products.filters.warehouse_id') }}</label>

            <select id="filter-warehouse_id" class="form-control" wire:model.live="warehouse_id">
                <option value="" selected>{{ __('globals.select') }}</option>

                @foreach($warehouses as $warehouseId => $warehouseName)
                    <option value="{{ $warehouseId }}">{{ $warehouseName }}</option>
                @endforeach
            </select>

            @error('warehouse_id') <span class="form-input-error text-danger"></span> @enderror
        </div>

        <div class="col-12 col-sm-6 col-md-4 mb-5">
            <label class="form-label">{{ __('admin.reports.out_of_stock_products.filters.employee_id') }}</label>

            <select id="filter-employee_id" class="form-control" wire:model.live="employee_id">
                <option value="" selected>{{ __('globals.select') }}</option>

                @foreach($employees as $employeeId => $employeeName)
                    <option value="{{ $employeeId }}">{{ $employeeName }}</option>
                @endforeach
            </select>

            @error('employee_id') <span class="form-input-error text-danger"></span> @enderror
        </div>

        <div class="col-12 col-sm-6 col-md-4 mb-5">
            <label class="form-label">{{ __('admin.reports.out_of_stock_products.filters.aisle') }}</label>

            <select id="filter-aisle" class="form-control" wire:model.live="aisle">
                <option value="" selected>{{ __('globals.select') }}</option>

                @foreach($aisles as $aisleKey => $aisleName)
                    <option value="{{ $aisleKey }}">{{ $aisleName }}</option>
                @endforeach
            </select>

            @error('aisle') <span class="form-input-error text-danger"></span> @enderror
        </div>

        <div class="col-12 col-sm-6 col-md-4 mb-5">
            <label class="form-label">{{ __('admin.reports.out_of_stock_products.filters.shelf') }}</label>

            <select id="filter-shelf_id" class="form-control" wire:model.live="shelf_id">
                <option value="" selected>{{ __('globals.select') }}</option>

                @foreach($shelves as $shelfId => $shelfName)
                    <option value="{{ $shelfId }}">{{ $shelfName }}</option>
                @endforeach
            </select>

            @error('shelf_id') <span class="form-input-error text-danger"></span> @enderror
        </div>
    </div>
</form>

{{-- @script
    <script>
        Livewire.on('report-filters-mounted', (event) => {
            setTimeout(() => {
                $('#filter-warehouse_id').val(@this.get('warehouse_id')).trigger('change')
                $('#filter-employee_id').val(@this.get('employee_id')).trigger('change')
                $('#filter-aisle').val(@this.get('aisle')).trigger('change')
                $('#filter-shelf_id').val(@this.get('shelf_id')).trigger('change')
            }, 1000);
        })

        Livewire.on('report-filters-reset', (event) => {
            $('#filter-warehouse_id').val(null).trigger('change')
            $('#filter-employee_id').val(null).trigger('change')
            $('#filter-aisle').val(null).trigger('change')
            $('#filter-shelf_id').val(null).trigger('change')
        })

        $('#filter-warehouse_id').on('change', function() {
            @this.set('warehouse_id', $('#filter-warehouse_id').val())
            @this.apply()
        })

        $('#filter-employee_id').on('change', function() {
            @this.set('employee_id', $('#filter-employee_id').val())
            @this.apply()
        })

        $('#filter-aisle').on('change', function() {
            @this.set('aisle', $('#filter-aisle').val())
            @this.apply()
        })

        $('#filter-shelf_id').on('change', function() {
            @this.set('shelf_id', $('#filter-shelf_id').val())
            @this.apply()
        })
    </script>
@endscript --}}
