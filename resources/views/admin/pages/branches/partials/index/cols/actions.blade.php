@if(can('branches.edit'))
    <x-admin.table.actions.edit-button
        :href="route('admin.branches.edit',  $branch->id)"
    />
@endif

@if(can('branches.delete'))
    @php
        $enabled = $branch->employees_count == 0 && $branch->orders_count == 0;
    @endphp

    <x-admin.table.actions.delete-button
        :action="route('admin.branches.destroy',  $branch->id)"
        :showTooltip="! $enabled"
        :tooltip="__('admin.branches.errors.should_have_no_relations')"
        :disabled="! $enabled"
    />
@endif
