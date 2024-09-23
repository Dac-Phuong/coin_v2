<?php

namespace App\Livewire\Admin\Wallets;

use App\Models\Network;
use App\Models\PlanModel;
use App\Models\Wallets;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class UpdateWallet extends Component
{
    public $wallet_status;
    public $wallet_id;
    public $wallet_address;
    public $wallets;
    public $status;
    public $plan;
    public $network;
    public $network_id;
    public $plan_id;
    protected $listeners = ['update' => 'mount'];

    public function mount($id = null)
    {
        $this->wallets = Wallets::find($id);
        if ($this->wallets) {
            $this->wallet_address = $this->wallets->wallet_address;
            $this->status = $this->wallets->status;
            $this->network_id = $this->wallets->network_id;
            $this->plan_id = $this->wallets->plan_id;
        }
    }
    public function submit()
    {
        try {
            $this->wallets->wallet_address = $this->wallet_address;
            $this->wallets->plan_id = $this->plan_id;
            $this->wallets->network_id = $this->network_id;
            $this->wallets->status = $this->status;
            $this->wallets->save();
            $this->dispatch('success', 'Updated successfully.');
        } catch (\Exception $e) {
            $this->dispatch('error', 'There was an error updating the wallet.');
            Log::error('Wallet update error: ' . $e->getMessage());
        }
    }
    public function render()
    {
        $this->plan = PlanModel::get();
        $this->network = Network::get();
        return view('livewire.admin.wallets.update-wallet');
    }
}