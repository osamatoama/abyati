<a
    href="#" data-action="{{ route('employee.shelves.products.detach', ['shelf' => $shelf->id, 'product' => $product->id]) }}"
    class="detach-product-btn btn btn-outline btn-outline-danger btn-sm"
    data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('employee.shelves.actions.detach_product') }}"
>
    <i class="fas fa-minus pe-0"></i>
</a>
