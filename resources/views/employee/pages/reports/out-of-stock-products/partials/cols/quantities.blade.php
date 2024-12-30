@if(request('branch_id'))
    @php
        $quantity = $product->quantities->where('branch_id', request('branch_id'))->first();
    @endphp

    @if($quantity && $quantity->branch)
        <div class="badge badge-lg @if($quantity->quantity > 0) badge-secondary @else badge-danger @endif mb-1">
            {{ $quantity->branch->name }}: {{ $quantity->quantity }}
        </div>
    @else
        ---
    @endif
@else
    @forelse ($product->quantities->whereNotNull('branch')->sortBy('branch_id') as $quantity)
        <div class="badge badge-lg @if($quantity->quantity > 0) badge-secondary @else badge-danger @endif mb-1">
            {{ $quantity->branch->name }}: {{ $quantity->quantity }}
        </div>
    @empty
        ---
    @endforelse
@endif
