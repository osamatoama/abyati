@forelse ($product->shelves as $shelf)
    <div class="badge badge-lg badge-secondary mb-1">
        {{ $shelf->warehouse->name }} : {{ $shelf->name }}
    </div>
@empty
    ---
@endforelse
