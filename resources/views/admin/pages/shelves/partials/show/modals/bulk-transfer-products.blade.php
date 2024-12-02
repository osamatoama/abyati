<div class="modal fade" id="bulk-transfer-products-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form id="bulk-transfer-products-form" action="{{ route('admin.shelves.products.bulk_transfer', ['shelf' => $shelf->id]) }}" autocomplete="off">
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title">
                        {{ __('globals.transfer') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="form-group mt-3 row">
                        <label for="bulk-transfer-products-form-aisle" class="col-md-2 form-label form-control-lg">{{ __('admin.shelves.attributes.aisle') }}</label>

                        <div class="col-md-10">
                            <select name="aisle" id="bulk-transfer-products-form-aisle" class="form-control" data-url="{{ route('admin.shelves.select.aisles') }}" data-warehouse-id="{{ $shelf->warehouse_id }}" disabled>
                            </select>

                            <span id="bulk-transfer-products-form-aisle-error" class="form-input-error text-danger d-none"></span>
                        </div>
                    </div>

                    <div class="form-group mt-3 row">
                        <label for="bulk-transfer-products-form-shelf_id" class="col-md-2 form-label form-control-lg">{{ __('admin.shelves.model') }}</label>

                        <div class="col-md-10">
                            <select name="shelf_id" id="bulk-transfer-products-form-shelf_id" class="form-control" data-url="{{ route('admin.shelves.select') }}" disabled>
                            </select>

                            <span id="bulk-transfer-products-form-shelf_id-error" class="form-input-error text-danger d-none"></span>
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
