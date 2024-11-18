@forelse ($product->shelves as $shelf)
    <div class="badge badge-lg badge-secondary">
        {{ $shelf->warehouse->name }} : {{ $shelf->name }}
    </div>
@empty
    ---
@endforelse
