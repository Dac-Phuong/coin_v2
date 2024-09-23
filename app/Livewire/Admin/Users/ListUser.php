<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class ListUser extends Component
{
    use WithPagination;

    #[Title('Danh sánh người dùng')]
    public $list_user;
    public $users;
    public $search = '';
    public $perpage = 20;
    protected $listeners = [
        'success' => 'update',
        'delete' => 'delete'
    ];

    public function render()
    {
        return view('livewire.admin.users.list-user', [
            'list_users' => User::search($this->search)->where('id', '!=', 1)->orderBy('created_at','desc')->paginate($this->perpage)
        ]);
    }
    public function update()
    {
        $this->list_user = User::all();
    }
    public function delete($id)
    {
        $user = User::find($id);
        if ($id == Auth::id()) {
            $this->dispatch('error', 'User deletion failed.');
            return;
        }
        if (!is_null($user)) {
            $user->delete();
        }
        $this->dispatch('success', 'User deletion successful.');
    }
}
