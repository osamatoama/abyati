<div>
    @foreach($permissions->groupBy("tag") as $key => $permissions)
        <div class="dev-module-container"
             data-module-name="{{ __("permissions.$key.title") }}">
            <hr>
            <fieldset class="row">
                <div class="col-md-3">
                    <div class="form-check form-check-custom form-check-solid form-check-sm"
                         wire:key="permissionsKeys{{ $key }}">
                        <input class="form-check-input" type="checkbox"
                               {{ ($permissions->where("tag", $key)->count() == $selectedPermissions->where("tag", $key)->count()) ? "checked" : "" }}
                               wire:click="checkAllTagPermission($event.target.checked, '{{ $key }}')"
                               id="permissionsKeys{{ $key }}"/>
                        <label class="form-check-label ms-1" for="permissionsKeys{{ $key }}">
                            {{ __("permissions.$key.title") }}
                        </label>
                    </div>
                </div>
                <div class="col-md-9">
                    @foreach($permissions as $permission)
                        <div class="form-check d-inline-block form-check-custom form-check-solid form-check-sm mb-1 me-2"
                             wire:key="permission_{{ $permission['id'] }}">
                            <input class="form-check-input" type="checkbox"
                                   name="permissions[]"
                                   wire:click="checkPermission($event.target.checked, {{ $permission['id'] }})"
                                   value="{{ $permission['id'] }}"
                                   {{ in_array($permission["id"], $selectedPermissionIds) ? "checked" : "" }}
                                   id="permission_{{ $permission['id'] }}"/>
                            <label class="form-check-label ms-1" for="permission_{{ $permission['id'] }}">
                                {{ __("permissions." . $permission["name"]) }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </fieldset>
        </div>
    @endforeach
</div>
