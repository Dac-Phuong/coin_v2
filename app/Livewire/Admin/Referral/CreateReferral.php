<?php

namespace App\Livewire\Admin\Referral;

use App\Models\Referals;
use Livewire\Component;

class CreateReferral extends Component
{
    public $amount_money;
    public $referral;

    public function mount()
    {
        $this->referral = Referals::first();
        if ($this->referral) {
            $this->amount_money = $this->referral->amount_money;
        }
    }
    public function submit()
    {
        $this->validate([
            "amount_money" => "required|numeric",
        ]);
        if ($this->referral) {
            $this->referral->amount_money = $this->amount_money;
            $this->referral->save();
        } else {
            $referral = Referals::create([
                'amount_money' => $this->amount_money,
            ]);
            $referral->save();
        }
        $this->dispatch('success', 'Successful commission change.');
    }
    public function render()
    {
        return view('livewire.admin.referral.create-referral');
    }
}
