@forelse ($product->categories as $category)
    <span class="badge badge-outline badge-info me-1 mb-1">
        {{ $category->name }}
    </span>
@empty
    ---
@endforelse
