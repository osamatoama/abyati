<div class="modal fade" id="create-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form id="create-form" action="{{ route("admin.users.store") }}" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{ __('admin.users.action.create') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="form-group mt-3 row">
                        <label for="create-form-name"
                            class="col-md-2 form-control-lg">{{ __('admin.users.attributes.name') }}</label>
                        <div class="col-md-10">
                            <input type="text" name="name" id="create-form-name" placeholder="{{ __('admin.users.attributes.name') }}"
                                class="form-control">
                            <span id="create-form-name-error" class="form-input-error text-danger d-none"></span>
                        </div>
                    </div>

                    <div class="form-group mt-3 row">
                        <label for="create-form-role_id" class="col-md-2 form-label form-control-lg">{{ __('admin.users.attributes.role') }}</label>
                        <div class="col-md-10">
                            <select name="role_id" id="create-form-role_id" class="form-control">
                                <option selected disabled> {{ __('globals.select') }}</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                            <span id="create-form-role_id-error" class="form-input-error text-danger d-none"></span>
                        </div>
                    </div>

                    <div class="form-group mt-3 row">
                        <label for="create-form-email"
                            class="col-md-2 form-control-lg">{{ __('admin.users.attributes.email') }}</label>
                        <div class="col-md-10">
                            <input type="email" name="email" id="create-form-email"
                                autocomplete="new-email"
                                placeholder="{{ __('admin.users.attributes.email') }}"
                                class="form-control">
                            <span id="create-form-email-error" class="form-input-error text-danger d-none"></span>
                        </div>
                    </div>

                    <div class="form-group mt-3 row">
                        <label for="create-form-phone"
                            class="col-md-2 form-control-lg">{{ __('admin.users.attributes.phone') }}</label>
                        <div class="col-md-10">
                            <input type="tel" name="phone" id="create-form-phone"
                                autocomplete="off"
                                placeholder="{{ __('admin.users.attributes.phone') }}"
                                class="form-control">
                            <span id="create-form-phone-error" class="form-input-error text-danger d-none"></span>
                        </div>
                    </div>

                    <div class="form-group mt-3 row fv-row" data-kt-password-meter="true">
                        <label class="col-md-2 form-control-lg" for="create-form-password">
                            {{ __('admin.users.attributes.password') }}
                        </label>

                        <div class="col-md-10">
                            <div class="position-relative mb-3">
                                <input id="create-form-password" class="form-control form-control-lg @error('password') is-invalid @enderror"
                                    type="password" placeholder="{{ __('admin.users.attributes.password') }}" name="password" autocomplete="new-password" />

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
                                {{ __("admin.users.password_hint") }}
                            </div>

                            <span id="create-form-password-error" class="form-input-error text-danger d-none"></span>
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
