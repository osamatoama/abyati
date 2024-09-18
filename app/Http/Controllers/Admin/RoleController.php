<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use Illuminate\Support\Facades\DB;
use App\Datatables\Admin\RoleIndex;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\Authorizable;
use App\Http\Requests\Admin\Role\StoreRoleRequest;
use App\Http\Requests\Admin\Role\DeleteRoleRequest;
use App\Http\Requests\Admin\Role\UpdateRoleRequest;

class RoleController extends Controller
{
    use Authorizable;

    protected $permissionName = 'roles';

    protected $additionalAbilities = [];

    public function index()
    {
        if (request()->ajax() or request()->expectsJson()) {
            return app(RoleIndex::class)->render();
        }

        return view('admin.pages.roles.index');
    }

    public function create()
    {
        return view('admin.pages.roles.create');
    }


    public function store(StoreRoleRequest $request)
    {
        DB::transaction(function () use (&$request) {
            $role = Role::create($request->validated());
            $role->permissions()->attach($request->input('permissions'));
        });

        session()->flash('success', __('admin.roles.messages.created'));

        return redirect()->route('admin.roles.index');
    }

    public function edit(Role $role)
    {
        abort_unless($role->isEditable(), 404);

        return view('admin.pages.roles.edit', compact('role'));
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        DB::transaction(function () use (&$request, &$role) {
            $role->update($request->validated());
            $role->permissions()->sync($request->input('permissions'));
        });

        session()->flash('success', __('admin.roles.messages.updated'));

        return redirect()->route('admin.roles.index');
    }

    public function destroy(DeleteRoleRequest $request, Role $role)
    {
        $role->delete();

        session()->flash('success', __('admin.roles.messages.deleted'));

        return redirect()->route('admin.roles.index');
    }
}
