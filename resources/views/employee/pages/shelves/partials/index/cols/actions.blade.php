<x-admin.table.actions.show-button
    :href="route('employee.shelves.show',  $shelf->id)"
/>

<a
    href="{{ route('employee.stocktakings.index', ['shelf_id' => $shelf->id]) }}"
    class="btn btn-outline btn-outline-primary btn-sm"
    data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('employee.stocktakings.title') }}"
>
    <i class="fas fa-boxes-stacked pe-0"></i>
</a>
