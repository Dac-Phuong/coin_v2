<?php

namespace App\Livewire\Admin\Roles;

use App\Models\User;
use Livewire\Attributes\Title;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class ListRole extends Component
{
    #[Title('Danh sánh vai trò')]
    protected $listeners = [
        'success' => 'update',
        'delete' => 'delete'
    ];

    public $list_role;
    public $roles;

    public function render()
    {
        $this->list_role = Role::get();
        foreach ($this->list_role as $role) {
            $role['users'] = User::where('role', $role->name)->get();
        }
        return view('livewire.admin.roles.list-role');
    }
    public function update()
    {
        $this->roles = Role::all();
    }
    public function delete($id)
    {
        $roles = Role::find($id);
        if (!is_null($roles) && $roles->id !== 1) {
            $roles->delete();
            $this->dispatch('success', 'Role deletion successful.');
        }else{
            $this->dispatch('error', 'This role cannot be deleted.');
        }
        
    }
    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }
}
