@if(can('shelves.edit'))
    <a
        href="#" data-action="{{ route('admin.shelves.products.detach', ['shelf' => $shelf->id, 'product' => $product->id]) }}"
        class="detach-product-btn btn btn-outline btn-outline-danger btn-sm"
        data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('admin.shelves.actions.detach_product') }}"
    >
        <i class="fas fa-minus pe-0"></i>
    </a>
@endif
