<div class="modal fade" id="import-aisle-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form id="import-aisle-form" action="{{ route('admin.shelves.import.aisle') }}" autocomplete="off" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{ __('admin.shelves.actions.import') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="download-templates d-flex gap-3 mb-5">
                        <a href="{{ asset('imports/admin/templates/warehouse/aisle-products.xlsx') }}" class="btn btn-sm btn-success" download>
                            <i class="fas fa-file-arrow-down"></i> {{ __('admin.shelves.actions.download_aisle_template') }}
                        </a>
                    </div>

                    <div class="form-group mt-3 row">
                        <label for="import-aisle-form-warehouse_id" class="col-md-2 form-label form-control-lg">{{ __('admin.shelves.attributes.warehouse') }}</label>

                        <div class="col-md-10">
                            <select name="warehouse_id" id="import-aisle-form-warehouse_id" class="form-control">
                                <option selected disabled> {{ __('globals.select_warehouse') }}</option>

                                @foreach($warehouses as $warehouseId => $warehouseName)
                                    <option value="{{ $warehouseId }}">{{ $warehouseName }}</option>
                                @endforeach
                            </select>

                            <span id="import-aisle-form-warehouse_id-error" class="form-input-error text-danger d-none"></span>
                        </div>
                    </div>

                    <div class="form-group mt-3 row">
                        <label for="import-aisle-form-aisle" class="col-md-2 form-label form-control-lg">{{ __('admin.shelves.attributes.aisle') }}</label>

                        <div class="col-md-10">
                            <select name="aisle" id="import-aisle-form-aisle" class="form-control" data-url="{{ route('admin.shelves.select.aisles') }}" disabled>
                                <option selected disabled> {{ __('globals.select_aisle') }}</option>
                            </select>

                            <span id="import-aisle-form-aisle-error" class="form-input-error text-danger d-none"></span>
                        </div>
                    </div>

                    <div class="form-group mt-3 row">
                        <label class="col-md-2 form-label form-control-lg">{{ __('globals.import_file') }}</label>

                        <div class="col-md-10">
                            <input id="import-aisle-form-file" type="file" class="form-control import-aisle-form-file" name="file" />

                            <span id="import-aisle-form-file-error" class="form-input-error text-danger d-none">
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        {{ __('globals.close') }}
                    </button>
                    <button type="submit" class="btn btn-primary">
                        {{ __('globals.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
