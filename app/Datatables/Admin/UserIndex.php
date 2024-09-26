<?php

namespace App\Datatables\Admin;

use App\Models\User;
use App\Enums\UserRole;
use App\Datatables\Datatable;

class UserIndex extends Datatable
{
    public function query()
    {
        return User::query()
            ->with([
                'roles' => fn($q) => $q->select('id', 'name'),
            ])
            ->whereHas('roles', function ($q) {
                $q->whereNotIn('name', UserRole::values());
            });
    }

    /**
     *
     * @return array
     */
    protected function addColumns()
    {
        return [
            'role' => function (User $user) {
                return view('admin.pages.users.partials.index.cols.role', compact('user'));
            },
            'action' => function (User $user) {
                return view('admin.pages.users.partials.index.cols.actions', compact('user'));
            },
        ];
    }

    /**
     * @return array
     */
    public function editColumns()
    {
        return [
            'phone' => function (User $user) {
                return view('admin.pages.users.partials.index.cols.phone', compact('user'));
            },
            'active' => function (User $user) {
                return view('admin.pages.users.partials.index.cols.active', compact('user'));
            },
        ];
    }
}
