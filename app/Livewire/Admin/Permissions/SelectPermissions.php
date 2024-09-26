<?php

namespace App\Livewire\Admin\Permissions;

use Livewire\Component;
use App\Models\Permission;

class SelectPermissions extends Component
{
    public $permissions;

    public $selectedPermissionIds = [];

    protected $listeners = [
        'permissionsChangedEvent' => 'permissionsChangedListener',
    ];

    public $selectedPermissions;

    public function mount($role = null)
    {
        $this->selectedPermissions = collect([]);
        $this->permissions = Permission::all();

        if ($role) {
            foreach ($role->permissions->pluck('id')->toArray() ?? [] as $permissionId) {
                $this->checkPermission(true, $permissionId);
                $this->permissionsChangedListener();
            }

        } else {
            foreach (old('permissions') ?? [] as $permissionId) {
                $this->checkPermission(true, $permissionId);
                $this->permissionsChangedListener();
            }
        }
    }

    public function checkPermission($checked, $permissionId)
    {
        if ($checked) {
            $this->selectedPermissions->put($permissionId, $this->permissions->where('id', $permissionId)->first());
        } else {
            unset($this->selectedPermissions[$permissionId]);
        }

        $this->dispatch('permissionsChangedEvent');
    }

    public function checkAllTagPermission($checked, $tag)
    {
        if ($checked) {
            $this->permissions->where('tag', $tag)->map(function ($item) {
                $this->selectedPermissions->put($item['id'], $item);
            });
        } else {
            $this->selectedPermissions = $this->selectedPermissions->where('tag', '!=', $tag);
        }
        $this->dispatch('permissionsChangedEvent');
    }

    public function permissionsChangedListener()
    {
        $this->selectedPermissionIds = $this->selectedPermissions->pluck('id')->toArray();
    }

    public function render()
    {
        return view('livewire.admin.permissions.select-permissions');
    }
}
