@forelse ($employee->roles ?? [] as $role)
    <span class="badge badge-outline badge-info mb-1">
        {{ lang("admin.employees.roles.$role") }}
    </span>
@empty
    ---
@endforelse
