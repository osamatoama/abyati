<div class="form-check form-switch form-check-custom form-check-solid">
    <input class="form-check-input toggle-active-row-button"
        id="toggle-active-row-button-{{ $store->active }}"
        data-url="{{ route('admin.stores.toggle_active', $store->id) }}"
        name="active" type="checkbox" @checked($store->active) value="1"
    />
</div>
