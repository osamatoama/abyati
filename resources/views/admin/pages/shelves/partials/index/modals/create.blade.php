<div class="modal fade" id="create-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form id="create-form" action="{{ route('admin.shelves.store') }}" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{ __('admin.shelves.actions.create') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="form-group mt-3 row">
                        <label for="create-form-warehouse_id" class="col-md-2 form-label form-control-lg">{{ __('admin.shelves.attributes.warehouse') }}</label>

                        <div class="col-md-10">
                            <select name="warehouse_id" id="create-form-warehouse_id" class="form-control">
                                <option selected disabled> {{ __('globals.select') }}</option>
                                @foreach($warehouses as $warehouseId => $warehouseName)
                                    <option value="{{ $warehouseId }}">{{ $warehouseName }}</option>
                                @endforeach
                            </select>

                            <span id="create-form-warehouse_id-error" class="form-input-error text-danger d-none"></span>
                        </div>
                    </div>

                    <div class="form-group mt-3 row">
                        <label class="col-md-2 form-label form-control-lg">{{ __('admin.shelves.attributes.aisle') }}</label>

                        <div class="col-md-10">
                            <input id="create-form-aisle" type="text" class="form-control create-form-aisle" name="aisle" />

                            <span id="create-form-aisle-error" class="form-input-error text-danger d-none">
                        </div>
                    </div>

                    <div class="form-group mt-3 row">
                        <label class="col-md-2 form-label form-control-lg">{{ __('admin.shelves.attributes.name') }}</label>

                        <div class="col-md-10">
                            <input id="create-form-name" type="text" class="form-control create-form-name" name="name" />

                            <span id="create-form-name-error" class="form-input-error text-danger d-none">
                        </div>
                    </div>

                    <div class="form-group mt-3 row">
                        <label class="col-md-2 form-label form-control-lg">{{ __('admin.shelves.attributes.description') }}</label>

                        <div class="col-md-10">
                            <input id="create-form-description" type="text" class="form-control create-form-description" name="description" />

                            <span id="create-form-description-error" class="form-input-error text-danger d-none">
                        </div>
                    </div>

                    <div class="form-group mt-3 row">
                        <label for="create-form-employee_ids" class="col-md-2 form-label form-control-lg">{{ __('admin.shelves.attributes.employees') }}</label>

                        <div class="col-md-10">
                            <select name="employee_ids[]" id="create-form-employee_ids" class="form-control" data-control="select2" data-placeholder="{{ __('globals.select') }}" multiple>
                                @foreach($stocktakingEmployees as $employee)
                                    <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                @endforeach
                            </select>

                            <span id="create-form-employee_ids-error" class="form-input-error text-danger d-none"></span>
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
