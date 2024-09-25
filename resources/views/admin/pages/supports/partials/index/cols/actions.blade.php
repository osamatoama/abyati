@if(can('supports.edit'))
    <x-admin.table.actions.edit-button
        data-action="{{ route('admin.supports.update', $support->id) }}"
        data-name="{{ $support->name }}"
        data-email="{{ $support->email }}"
        data-phone="{{ $support->phone }}"
    />
@endif

@if(can('supports.delete') && ! $support->order_statuses_exists)
    <x-admin.table.actions.delete-button
        :action="route('admin.supports.destroy', $support->id)"
    />
@endif
