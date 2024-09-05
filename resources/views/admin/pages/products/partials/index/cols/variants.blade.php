@forelse($product->variants as $variant)
    <p class="border p-1 mb-1">
        {{ $variant->optionValues->map(fn($optionValue) => $optionValue->option->name . ': ' . $optionValue->name)->implode(' - ') }}
    </p>
@empty
    -----
@endforelse
