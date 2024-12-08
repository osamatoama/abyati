<div class="modal fade" id="edit-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form id="edit-form" action="#" autocomplete="off">
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title">
                        {{ __('admin.employees.action.edit') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="form-group mt-3 row">
                        <label for="edit-form-name"
                            class="col-md-2 form-control-lg">{{ __('admin.employees.attributes.name') }}</label>
                        <div class="col-md-10">
                            <input type="text" name="name" id="edit-form-name" placeholder="{{ __('admin.employees.attributes.name') }}"
                                class="form-control">
                            <span id="edit-form-name-error" class="form-input-error text-danger d-none"></span>
                        </div>
                    </div>

                    <div class="form-group mt-3 row">
                        <label for="update-form-branch_id" class="col-md-2 form-label form-control-lg">{{ __('admin.employees.attributes.branch') }}</label>
                        <div class="col-md-10">
                            <select name="branch_id" id="update-form-branch_id" class="form-control">
                                <option selected disabled> {{ __('globals.select') }}</option>
                                @foreach($branches as $branchId => $branchName)
                                    <option value="{{ $branchId }}">{{ $branchName }}</option>
                                @endforeach
                            </select>
                            <span id="update-form-branch_id-error" class="form-input-error text-danger d-none"></span>
                        </div>
                    </div>

                    <div class="form-group mt-3 row">
                        <label for="edit-form-email"
                            class="col-md-2 form-control-lg">{{ __('admin.employees.attributes.email') }}</label>
                        <div class="col-md-10">
                            <input type="email" name="email" id="edit-form-email"
                                autocomplete="new-email"
                                placeholder="{{ __('admin.employees.attributes.email') }}"
                                class="form-control">
                            <span id="edit-form-email-error" class="form-input-error text-danger d-none"></span>
                        </div>
                    </div>

                    <div class="form-group mt-3 row">
                        <label for="edit-form-phone"
                            class="col-md-2 form-control-lg">{{ __('admin.employees.attributes.phone') }}</label>
                        <div class="col-md-10">
                            <input type="tel" name="phone" id="edit-form-phone"
                                autocomplete="off"
                                placeholder="{{ __('admin.employees.attributes.phone') }}"
                                class="form-control">
                            <span id="edit-form-phone-error" class="form-input-error text-danger d-none"></span>
                        </div>
                    </div>

                    <div class="form-group mt-3 row fv-row" data-kt-password-meter="true">
                        <label class="col-md-2 form-control-lg" for="edit-form-password">
                            {{ __('admin.employees.attributes.password') }}
                        </label>

                        <div class="col-md-10">
                            <div class="position-relative mb-3">
                                <input id="edit-form-password" class="form-control form-control-lg @error('password') is-invalid @enderror"
                                    type="password" placeholder="{{ __('admin.employees.attributes.password') }}" name="password" autocomplete="new-password" />

                                <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2"
                                    data-kt-password-meter-control="visibility">
                                        <i class="ki-duotone ki-eye-slash fs-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
                                        <i class="ki-duotone ki-eye d-none fs-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                </span>
                            </div>

                            <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                            </div>

                            <div class="text-muted">
                                {{ __("admin.employees.password_hint") }}
                            </div>

                            <span id="edit-form-password-error" class="form-input-error text-danger d-none"></span>
                        </div>
                    </div>

                    <div class="form-group mt-3 row">
                        <label for="edit-form-roles" class="col-md-2 form-label form-control-lg">{{ __('admin.employees.attributes.roles') }}</label>
                        <div class="col-md-10">
                            <select name="roles[]" id="edit-form-roles" class="form-control" data-control="select2" data-placeholder="{{ __('globals.select') }}" multiple>
                                @foreach(\App\Enums\EmployeeRole::toSelectArray() as $roleKey => $roleValue)
                                    <option value="{{ $roleKey }}">{{ $roleValue }}</option>
                                @endforeach
                            </select>
                            <span id="edit-form-roles-error" class="form-input-error text-danger d-none"></span>
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
