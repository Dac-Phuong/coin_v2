<?php

namespace App\Livewire\Admin\Wallets;

use App\Models\Wallets;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class ListWallet extends Component
{
    use WithPagination;

    public $search = '';
    public $perpage = 20;
    public $wallets;
    public $wallet_id;
    public $id;
    public $toggleState = false;
    protected $listeners = [
        'success' => 'render',
        'delete' => 'delete'
    ];


    public function mount($id)
    {
        if ($id) {
            $this->wallet_id = $id;
        }
    }
    public function toggle($id = null)
    {
        if ($id != $this->wallet_id) {
            $this->wallet_id = $id;
            $this->toggleState = true;
        } else {
            $this->toggleState = !$this->toggleState;
        }
    }
    public function closeToggle()
    {
        $this->toggleState = false;
    }
    public function delete($id)
    {
        $wallet = Wallets::find($id);
        if (!is_null($wallet)) {
            $wallet->delete();
        }
        $this->dispatch('success', 'Wallet deleted successfully.');
    }
    public function render()
    {
        $list_wallet = DB::table('wallets')
            ->join('plan_models', 'plan_models.id', '=', 'wallets.plan_id')
            ->join('networks', 'networks.id', '=', 'wallets.network_id')
            ->select('wallets.*', 'networks.network_name as network_name', 'plan_models.name as plan_name')
            ->where('network_id', $this->id)
            ->orderBy('wallets.created_at', 'DESC')
            ->paginate($this->perpage);
        return view('livewire.admin.wallets.list-wallet', ['list_wallet' => $list_wallet]);
    }
}