<div class="form-check form-switch form-check-custom form-check-solid">
    <input class="form-check-input toggle-active-row-button"
        id="toggle-active-row-button-{{ $branch->active }}"
        data-url="{{ route('admin.branches.toggle_active', $branch->id) }}"
        name="active" type="checkbox" @checked($branch->active) value="1"
    />
</div>
