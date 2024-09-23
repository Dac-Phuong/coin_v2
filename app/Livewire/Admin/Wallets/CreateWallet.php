<?php

namespace App\Livewire\Admin\Wallets;

use App\Models\Network;
use App\Models\PlanModel;
use App\Models\Wallets;
use Livewire\Component;

class CreateWallet extends Component
{
    public $address_wallet;
    public $wallet_type = 0;
    public $plan;
    public $plan_id;
    public $network_id;
    public $network;
    public $wallet_name;

    public function submit()
    {
        $this->validate([
            'address_wallet' => 'required',
            'plan_id' => 'required',
            'network_id' => 'required'
        ], [], [
            'address_wallet' => 'wallet address',
            'plan_id' => 'plans',
            'network_id' => 'networks',
        ]);

        $new_array = array_filter(explode("\n", $this->address_wallet), 'strlen');
        foreach ($new_array as $key => $address) {
            $wallets = Wallets::create([
                'plan_id' => $this->plan_id,
                'network_id' => $this->network_id,
                'wallet_address' => $address,
            ]);
            $wallets->save();
        }
        try {
            $this->dispatch('success', 'Add wallet successfully.');
        } catch (\Exception $e) {
            $this->dispatch('error', $e->getMessage());
        }
        $this->reset();
    }
    public function render()
    {
        $this->plan = PlanModel::get();
        // dd($this->plan);
        $this->network = Network::get();
        return view('livewire.admin.wallets.create-wallet');
    }
}