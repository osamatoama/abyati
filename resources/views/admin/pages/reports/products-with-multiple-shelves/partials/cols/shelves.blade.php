@forelse ($product->shelves as $shelf)
    <div class="mb-1">
        <span class="badge badge-lg badge-secondary">
            {{ $shelf->descriptive_name }}
        </span>
    </div>
@empty
    ---
@endforelse
