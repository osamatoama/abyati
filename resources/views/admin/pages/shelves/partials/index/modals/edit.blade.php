<div class="modal fade" id="edit-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form id="edit-form" action="#" autocomplete="off">
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title">
                        {{ __('admin.shelves.actions.edit') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="form-group mt-3 row">
                        <label for="edit-form-warehouse_id" class="col-md-2 form-label form-control-lg">{{ __('admin.shelves.attributes.warehouse') }}</label>

                        <div class="col-md-10">
                            <select name="warehouse_id" id="edit-form-warehouse_id" class="form-control">
                                <option selected disabled> {{ __('globals.select') }}</option>
                                @foreach($warehouses as $warehouseId => $warehouseName)
                                    <option value="{{ $warehouseId }}">{{ $warehouseName }}</option>
                                @endforeach
                            </select>

                            <span id="edit-form-warehouse_id-error" class="form-input-error text-danger d-none"></span>
                        </div>
                    </div>

                    <div class="form-group mt-3 row">
                        <label class="col-md-2 form-label form-control-lg">{{ __('admin.shelves.attributes.aisle') }}</label>

                        <div class="col-md-10">
                            <input id="edit-form-aisle" type="text" class="form-control edit-form-aisle" name="aisle" />

                            <span id="edit-form-aisle-error" class="form-input-error text-danger d-none">
                        </div>
                    </div>

                    <div class="form-group mt-3 row">
                        <label class="col-md-2 form-label form-control-lg">{{ __('admin.shelves.attributes.name') }}</label>

                        <div class="col-md-10">
                            <input id="edit-form-name" type="text" class="form-control edit-form-name" name="name" />

                            <span id="edit-form-name-error" class="form-input-error text-danger d-none">
                        </div>
                    </div>

                    <div class="form-group mt-3 row">
                        <label class="col-md-2 form-label form-control-lg">{{ __('admin.shelves.attributes.description') }}</label>

                        <div class="col-md-10">
                            <input id="edit-form-description" type="text" class="form-control edit-form-description" name="description" />

                            <span id="edit-form-description-error" class="form-input-error text-danger d-none">
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
