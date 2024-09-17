<div class="modal fade" id="transfer-item-{{ $item->id }}-modal" tabindex="-1" aria-labelledby="transfer-item-{{ $item->id }}-modal-label" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="transfer-item-{{ $item->id }}-modal-label">
                    {{ $item->product->name }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div>
                    <form wire:submit.prevent="transferToSupport">
                        <div class="alert bg-warning d-flex flex-column flex-sm-row p-5 mb-10">
                            <i class="ki-duotone ki-search-list fs-2hx text-light me-4 mb-5 mb-sm-0"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>

                            <div class="d-flex flex-column pe-0 pe-sm-10">
                                <h4 class="mb-2 fw-semibold">
                                    {{ __('globals.alert') }}
                                </h4>
                                <span>
                                    {{ __('employee.orders.items.alerts.transfer_to_support') }}
                                </span>
                            </div>
                        </div>

                        <div class="row product-image-wrapper mb-5">
                            <div class="col-md-6">
                                <img src="{{ $item->product->main_image }}" class="img-fluid">
                            </div>

                            <div class="col-md-6 d-flex align-items-center justify-content-center">
                                <ul class="list-unstyled fs-lg">
                                    <li>
                                        <strong>{{ __('employee.orders.items.attributes.quantity') }} = </strong>
                                        <span>{{ $item->quantity }}</span>
                                    </li>
                                    <li>
                                        <strong>{{ __('employee.orders.items.attributes.executed_quantity') }} = </strong>
                                        <span>{{ $item->executed_quantity }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="mb-10">
                            <div class="col-12 mb-5">
                                <label class="form-label">{{ __('employee.orders.items.attributes.employee_note') }}</label>

                                <textarea class="form-control @error('employee_note') is-invalid @enderror" wire:model="employee_note"></textarea>

                                @error('employee_note') <span class="form-input-error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-sm btn-primary" data-kt-menu-dismiss="true">
                                {{ __('employee.orders.actions.transfer') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
