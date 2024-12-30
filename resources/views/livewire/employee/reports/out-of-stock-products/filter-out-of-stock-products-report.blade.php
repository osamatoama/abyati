<form>
    <div class="row">
        <div class="col-12 col-sm-6 col-md-4 mb-5">
            <label class="form-label">{{ __('employee.reports.out_of_stock_products.filters.aisle') }}</label>

            <select id="filter-aisle" class="form-control" wire:model.live="aisle">
                <option value="" selected>{{ __('globals.select') }}</option>

                @foreach($aisles as $aisleKey => $aisleName)
                    <option value="{{ $aisleKey }}">{{ $aisleName }}</option>
                @endforeach
            </select>

            @error('aisle') <span class="form-input-error text-danger"></span> @enderror
        </div>

        <div class="col-12 col-sm-6 col-md-4 mb-5">
            <label class="form-label">{{ __('employee.reports.out_of_stock_products.filters.shelf') }}</label>

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
