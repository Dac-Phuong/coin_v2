<?php

namespace App\Livewire\Admin\Roles;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateRole extends Component
{
    public $role;
    public $permissions = [];
    public $selectAll = false;
  
    public function submit()
    {
        $this->validate([
            'role' => 'required|unique:roles,name',
            'permissions' => 'required|array',
        ]);

        $role = Role::create(['name' => $this->role]);
        $role->syncPermissions($this->permissions);
        
        $this->reset(['role', 'permissions']);
        $this->dispatch('success', 'Add roles successfully.');
    }
    public function render()
    {
        if ($this->selectAll) {
            $permissions = Permission::pluck('name')->toArray();
            $this->permissions = $permissions;
        } else {
            $this->permissions = [];
        }
        return view('livewire.admin.roles.create-role');
    }
    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }
}
