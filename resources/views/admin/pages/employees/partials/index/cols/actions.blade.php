@if(can('employees.edit'))
    <x-admin.table.actions.edit-button
        data-action="{{ route('admin.employees.update', $employee->id) }}"
        data-name="{{ $employee->name }}"
        data-branch-id="{{ $employee->branch_id }}"
        data-email="{{ $employee->email }}"
        data-phone="{{ $employee->phone }}"
    />
@endif

@if(can('employees.delete') && ! $employee->order_statuses_exists)
    <x-admin.table.actions.delete-button
        :action="route('admin.employees.destroy', $employee->id)"
    />
@endif
