<div class="modal fade" id="pull-orders-modal" tabindex="-1" aria-labelledby="pull-orders-modal-label" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="pull-orders-form" wire:submit.prevent="pullOrders" method="POST">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title" id="pull-orders-modal-label">{{ __('admin.orders.pull_alert.title') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-12 mb-5">
                            <label class="form-label">{{ __('admin.orders.pull_form.store') }}</label>

                            <select class="form-control" wire:model="store_id">
                                <option value="" selected disabled> {{ __('globals.select_store') }}</option>
                                @foreach($stores as $storeId => $storeName)
                                    <option value="{{ $storeId }}">{{ $storeName }}</option>
                                @endforeach
                            </select>

                            @error('store_id') <span class="form-input-error text-danger d-none"></span> @enderror
                        </div>
                    </div>

                    <div class="form-group row" wire:ignore>
                        <div class="col-12 mb-5">
                            <label class="form-label">{{ __('admin.orders.pull_form.date') }}</label>

                            <input type="text" class="form-control" id="pull-orders-form-date" wire:model="date" />

                            @error('from_date') <span class="form-input-error text-danger">{{ $message }}</span> @enderror
                            @error('to_date') <span class="form-input-error text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('globals.close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('globals.pull') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

@pushonce('afterScripts')
    <script>
        flatpickr($('#pull-orders-form-date'), {
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

        Livewire.on('pull-orders-started', (message) => {
            closeModal($('#pull-orders-modal'))
            successToast(message)
        })
    </script>
@endpushonce
