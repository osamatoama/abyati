@if($canPullOrders)
    <div class="alert bg-primary d-flex flex-column flex-sm-row p-5 mb-10">
        <i class="fa-solid fa-cloud-arrow-down fs-2hx text-light me-4 mb-5 mb-sm-0"></i>

        <div class="d-flex flex-column text-light pe-0 pe-sm-10">
            <h4 class="mb-2 text-light">
                {{ __('orders.pull_alert.title') }}
            </h4>
            <span>
                {{ __('orders.pull_alert.body') }}
            </span>
        </div>

        <button class="btn btn-sm btn-light ms-auto my-2" data-bs-toggle="modal" data-bs-target="#pull-orders-modal">
            {{ __('orders.pull_alert.button') }}
        </button>
    </div>

    <div class="modal fade" id="pull-orders-modal" tabindex="-1" aria-labelledby="pull-orders-modal-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="pull-orders-form" action="{{ route('client.orders.pull.setup') }}" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="pull-orders-modal-label">{{ __('orders.pull_alert.title') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <div class="col-12 mb-5">
                                <label for="pull-orders-form-orders_count" class="form-label">{{ __('orders.pull_form.orders_count') }}</label>
                                <input type="number" class="form-control" id="pull-orders-form-orders_count" name="orders_count" min="1" />
                                <span id="pull-orders-form-orders_count-error" class="form-input-error text-danger d-none"></span>
                            </div>

                            <div class="col-12 mb-5">
                                <label for="pull-orders-form-to_date" class="form-label">{{ __('orders.pull_form.to_date') }}</label>
                                <input type="number" class="form-control" id="pull-orders-form-to_date" name="to_date" min="1" />
                                <span id="pull-orders-form-to_date-error" class="form-input-error text-danger d-none"></span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('general.close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('general.pull') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('afterScripts')
        <script>
            flatpickr($('#pull-orders-form-to_date'), {
                defaultDate: new Date(),
                disable: [
                    function(date) {
                        return date > new Date
                    }
                ]
            })

            const pullOrdersForm = $('#pull-orders-form')
            const pullOrdersModal = $('#pull-orders-modal')

            pullOrdersForm.submit(function (e) {
                e.preventDefault()
                disableSubmit(pullOrdersForm)
                hideFormValidationErrors(pullOrdersForm)

                axios.post(pullOrdersForm.attr('action'), getFormData(pullOrdersForm))
                    .then((response) => {
                        resetForm(pullOrdersForm)
                        closeModal(pullOrdersModal)
                        successToast(response?.data?.message || getTranslation('updatedSuccessfully'))
                        reloadPage()
                    })
                    .catch((error) => {
                        handleAjaxFormError(error, pullOrdersForm)
                    })
                    .then(() => {
                        enableSubmit(pullOrdersForm)
                    })
            })
        </script>
    @endpush
@endif
