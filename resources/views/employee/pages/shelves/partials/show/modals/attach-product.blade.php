<div class="modal fade" id="attach-product-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form id="attach-product-form" action="{{ route('employee.shelves.products.attach', ['shelf' => $shelf->id]) }}" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{ __('employee.shelves.actions.attach_product') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="form-group mt-3 row">
                        <label for="attach-product-form-product_ids" class="col-md-2 form-label form-control-lg">{{ __('employee.products.title') }}</label>

                        <select
                            id="attach-product-form-product_ids" class="form-select form-select-solid attach-product-form-product_ids"
                            name="product_ids[]"
                            data-ajax-url="{{ route('employee.products.select') }}"
                            data-placeholder="{{ __('globals.select_product') }}"
                            multiple
                        >
                        </select>

                        <span id="attach-product-form-product_ids-error" class="form-input-error text-danger d-none"></span>
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
