@if($branch->relatedOrderStatus)
    <span class="badge badge-info">
        {{ $branch->relatedOrderStatus->name }}
    </span>
@else
    ---
@endif
