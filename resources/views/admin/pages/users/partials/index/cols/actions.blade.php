@if(can('users.edit'))
    <x-admin.table.actions.edit-button
        data-action="{{ route('admin.users.update', $user->id) }}"
        data-name="{{ $user->name }}"
        data-role-id="{{ $user->roles->first()?->id }}"
        data-email="{{ $user->email }}"
        data-phone="{{ $user->phone }}"
    />
@endif

@if(can('users.delete') && ! $user->order_statuses_exists)
    <x-admin.table.actions.delete-button
        :action="route('admin.users.destroy', $user->id)"
    />
@endif
