@if(can('shelves.show'))
    <x-admin.table.actions.show-button
        :href="route('admin.shelves.show',  $shelf->id)"
    />
@endif

{{-- @if(can('shelves.edit'))
    <x-admin.table.actions.edit-button
        :href="route('admin.shelves.edit',  $branch->id)"
    />
@endif

@if(can('shelves.delete'))
    @php
        $enabled = $branch->employees_count == 0 && $branch->orders_count == 0;
    @endphp

    <x-admin.table.actions.delete-button
        :action="route('admin.shelves.destroy',  $branch->id)"
        :showTooltip="! $enabled"
        :tooltip="__('admin.shelves.errors.should_have_no_relations')"
        :disabled="! $enabled"
    />
@endif --}}
