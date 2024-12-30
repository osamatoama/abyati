{{ $product->name }}

@if($product->status == \App\Enums\ProductStatus::DELETED->value)
    <div class="mt-1">
        <span class="badge badge-sm badge-danger">
            {{ __('globals.deleted') }}
        </span>
    </div>
@endif
