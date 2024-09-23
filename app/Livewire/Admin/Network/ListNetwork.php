<?php

namespace App\Livewire\Admin\Network;

use App\Models\Network;
use Livewire\Component;

class ListNetwork extends Component
{
    public $perpage = 20;
    public $search = '';
    protected $listeners = [
        'success' => 'render',
        'delete' => 'delete'
    ];
    public function delete($id)
    {
        $network = Network::find($id);
        if (!is_null($network)) {
            $network->delete();
            $this->dispatch('success', 'Delete successfully.');
        } else {
            $this->dispatch('error', 'Delete Faild.');
        }
    }
    public function render()
    {
        $list_network = Network::search($this->search)->orderBy('created_at', 'DESC')->paginate($this->perpage);
        return view('livewire.admin.network.list-network', ['list_network' => $list_network]);
    }
}