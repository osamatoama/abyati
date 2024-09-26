<div class="form-check form-switch form-check-custom form-check-solid">
    <input class="form-check-input toggle-active-row-button"
        id="toggle-active-row-button-{{ $employee->active }}"
        data-url="{{ route('admin.employees.toggle_active', $employee->id) }}"
        name="active" type="checkbox" @checked($employee->active) value="1"
    />
</div>
