<input
    type="color"
    class="store-id-color form-control form-control-color p-1"
    id="store-id-color-{{ $store->id }}"
    value="{{ $store->id_color }}"
    data-action="{{ route('admin.stores.update', $store->id) }}"
/>
