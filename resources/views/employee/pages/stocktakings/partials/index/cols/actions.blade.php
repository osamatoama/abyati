{{-- <x-admin.table.actions.show-button
    :href="route('employee.stocktakings.show',  $stocktaking->id)"
/> --}}

@if($stocktaking->isPending())
    <a
        href="{{ route('employee.stocktakings.process', ['stocktaking' => $stocktaking->id]) }}"
        class="btn btn-outline btn-outline-primary btn-sm"
        data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('employee.stocktakings.actions.process') }}"
    >
        <i class="fas fa-spinner pe-0"></i>
    </a>
@endif

<a
    href="{{ route('employee.stocktakings.show', ['stocktaking' => $stocktaking->id]) }}"
    class="btn btn-outline btn-outline-warning btn-sm"
    data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('employee.stocktakings.attributes.issues') }}"
>
    <i class="fas fa-triangle-exclamation pe-0"></i>
</a>
