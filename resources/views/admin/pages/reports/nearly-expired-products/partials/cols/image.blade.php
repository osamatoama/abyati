@if(filled($product->main_image))
    <a href="{{ $product->main_image }}" target="_blank">
        <img src="{{ $product->main_image }}" alt="{{ $product->name }}" width="100" height="100">
    </a>
@else
    -----
@endif
