<div class="modal fade" id="import-shelf-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form id="import-shelf-form" action="{{ route('admin.shelves.import.shelf') }}" autocomplete="off" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{ __('admin.shelves.actions.import') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="download-templates d-flex gap-3 mb-5">
                        <a href="{{ asset('imports/admin/templates/warehouse/shelf-products.xlsx') }}" class="btn btn-sm btn-success" download>
                            <i class="fas fa-file-arrow-down"></i> {{ __('admin.shelves.actions.download_shelf_template') }}
                        </a>
                    </div>

                    <div class="form-group mt-3 row">
                        <label for="import-shelf-form-warehouse_id" class="col-md-2 form-label form-control-lg">{{ __('admin.shelves.attributes.warehouse') }}</label>

                        <div class="col-md-10">
                            <select name="warehouse_id" id="import-shelf-form-warehouse_id" class="form-control">
                                <option selected disabled> {{ __('globals.select') }}</option>
                                @foreach($warehouses as $warehouseId => $warehouseName)
                                    <option value="{{ $warehouseId }}">{{ $warehouseName }}</option>
                                @endforeach
                            </select>

                            <span id="import-shelf-form-warehouse_id-error" class="form-input-error text-danger d-none"></span>
                        </div>
                    </div>

                    <div class="form-group mt-3 row">
                        <label for="import-shelf-form-shelf_id" class="col-md-2 form-label form-control-lg">{{ __('admin.shelves.model') }}</label>

                        <div class="col-md-10">
                            <select name="shelf_id" id="import-shelf-form-shelf_id" class="form-control" data-url="{{ route('admin.shelves.select') }}" disabled>
                                <option selected disabled> {{ __('globals.select_shelf') }}</option>
                            </select>

                            <span id="import-shelf-form-shelf_id-error" class="form-input-error text-danger d-none"></span>
                        </div>
                    </div>

                    <div class="form-group mt-3 row">
                        <label class="col-md-2 form-label form-control-lg">{{ __('globals.import_file') }}</label>

                        <div class="col-md-10">
                            <input id="import-shelf-form-file" type="file" class="form-control import-shelf-form-file" name="file" />

                            <span id="import-shelf-form-file-error" class="form-input-error text-danger d-none">
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
