<div class="form-check form-switch form-check-custom form-check-solid">
    <input class="form-check-input toggle-active-row-button"
        id="toggle-active-row-button-{{ $user->active }}"
        data-url="{{ route('admin.users.toggle_active', $user->id) }}"
        name="active" type="checkbox" @checked($user->active) value="1"
    />
</div>
