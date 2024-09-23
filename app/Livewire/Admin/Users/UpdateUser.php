<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class UpdateUser extends Component
{
    public $list_role;
    public $name;
    public $email;
    public $role_name;
    public $password;
    public $user;
    protected $listeners = ['update' => 'mount'];
    public function mount($id = null)
    {
        $this->user = User::find($id);
        if ($this->user) {
            $this->name = $this->user->name;
            $this->email = $this->user->email;
            $this->role_name = $this->user->role;
        }
    }
    public function render()
    {
        $this->list_role = Role::get();

        return view('livewire.admin.users.update-user');
    }

    public function submit()
    {
        $this->validate(
            [
                'name' => 'required|string|',
                'email' => 'required|email',
            ]
        );

        $this->user->syncRoles([]);
        $this->user->name = $this->name;
        $this->user->email = $this->email;
        $this->user->role = $this->role_name;
        if ($this->password) {
            $this->user->password = Hash::make($this->password);
        }
        $this->user->save();
        $role = Role::where('name', $this->user->role)->first();
        if ($role) {
            $this->user->assignRole($this->role_name);
        }
        $this->dispatch('success', 'User updated successfully.');

    }
    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }
}
