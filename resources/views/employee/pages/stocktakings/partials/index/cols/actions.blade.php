{{-- <x-admin.table.actions.show-button
    :href="route('employee.stocktakings.show',  $stocktaking->id)"
/> --}}

<a
    href="{{ route('employee.stocktakings.show', ['stocktaking' => $stocktaking->id]) }}"
    class="btn btn-outline btn-outline-warning btn-sm"
    data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('employee.stocktakings.attributes.issues') }}"
>
    <i class="fas fa-triangle-exclamation pe-0"></i>
</a>
