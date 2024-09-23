<?php

namespace App\Livewire\Admin\Roles;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UpdateRole extends Component
{
    public $permissions = [];
    public $role_name;
    public $role;
    public $selectAll = false;

    protected $listeners = ['update' => 'mount'];
    public function mount($id = null)
    {
        $this->role = Role::find($id);
        if ($this->role) {
            $this->role_name = $this->role->name;
            $this->permissions = $this->role->permissions->pluck('name')->toArray();
        }
    }

    public function submit()
    {
        $this->validate([
            'role_name' => 'required',
            'permissions' => 'required|array',
        ]);
        $this->role->name = $this->role_name;
        $this->role->save();
        $this->role->syncPermissions($this->permissions);

        $this->dispatch('success', 'Role update successful');
    }
    public function render()
    {
        if ($this->selectAll) {
            $permissions = Permission::pluck('name')->toArray();
            $this->permissions = $permissions;
        } else {
            $this->permissions = $this->role ? $this->role->permissions->pluck('name')->toArray() : [];
        }
        return view('livewire.admin.roles.update-role');
    }
    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }
}
