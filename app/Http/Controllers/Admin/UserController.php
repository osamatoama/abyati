<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Datatables\Admin\UserIndex;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\Authorizable;
use App\Http\Requests\Admin\User\StoreUserRequest;
use App\Http\Requests\Admin\User\DeleteUserRequest;
use App\Http\Requests\Admin\User\UpdateUserRequest;

class UserController extends Controller
{
    use Authorizable;

    protected $permissionName = 'users';

    protected $additionalAbilities = [];

    public function index()
    {
        if (request()->ajax() or request()->expectsJson()) {
            return app(UserIndex::class)->render();
        }

        $roles = Role::assignable()->get();

        return view('admin.pages.users.index', compact('roles'));
    }

    public function store(StoreUserRequest $request)
    {
        DB::transaction(function () use (&$request) {
            $user = User::create($request->validated());
            $user->assignRole(Role::findOrFail($request->input('role_id')));
        });

        return response()->json([
            'success' => true,
            'message' => __('admin.users.messages.created'),
            'data' => [],
        ]);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        DB::transaction(function () use (&$request, &$user) {
            $user->update($request->validated());
            $user->syncRoles(Role::findOrFail($request->input('role_id')));
        });

        return response()->json([
            'success' => true,
            'message' => __('admin.users.messages.updated'),
            'data' => [],
        ]);
    }

    public function toggleActive(User $user)
    {
        $user->toggleActive();

        return response()->json([
            'success' => true,
            'message' => __('admin.users.messages.' . ($user->active ? 'activated' : 'deactivated')),
        ]);
    }

    public function destroy(DeleteUserRequest $request, User $user)
    {
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => __('admin.users.messages.deleted'),
        ]);
    }
}
