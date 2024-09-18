@if(can('roles.edit'))
    <x-admin.table.actions.edit-button
        :href="route('admin.roles.edit',  $role->id)"
    />
@endif

@if(can('roles.delete'))
    <x-admin.table.actions.delete-button
        :action="route('admin.roles.destroy',  $role->id)"
    />
@endif
