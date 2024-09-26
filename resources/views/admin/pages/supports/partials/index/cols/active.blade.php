<div class="form-check form-switch form-check-custom form-check-solid">
    <input class="form-check-input toggle-active-row-button"
        id="toggle-active-row-button-{{ $support->active }}"
        data-url="{{ route('admin.supports.toggle_active', $support->id) }}"
        name="active" type="checkbox" @checked($support->active) value="1"
    />
</div>
