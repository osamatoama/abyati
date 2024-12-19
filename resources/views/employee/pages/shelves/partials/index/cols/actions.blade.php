<x-admin.table.actions.show-button
    :id="'show-row-btn-' . $shelf->id"
    :href="route('employee.shelves.show',  $shelf->id)"
/>

<a
    href="{{ route('employee.stocktakings.index', ['shelf_id' => $shelf->id]) }}"
    id="stocktakings-row-btn-{{ $shelf->id }}"
    class="stocktakings-row-btn btn btn-outline btn-outline-primary btn-sm"
    data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('employee.stocktakings.actions.stocktake_shelf') }}"
>
    <i class="fas fa-boxes-stacked pe-0"></i>
</a>
