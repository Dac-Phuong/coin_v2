<?php

namespace App\Livewire\Admin\Settings;

use App\Models\Referals;
use App\Models\Withdrawal_fees;
use Livewire\Component;

class IndexSettings extends Component
{
    public $amount_money;
    public $commissions;
    public $min_amount;
    public $widthdrawal_fees;
    public $referral_fees;
    public function mount()
    {
        $this->widthdrawal_fees = Withdrawal_fees::first();
        $this->referral_fees = Referals::first();
        if ($this->widthdrawal_fees) {
            $this->amount_money = $this->widthdrawal_fees->amount_money;
            $this->min_amount = $this->widthdrawal_fees->min_amount;
        }
        if ($this->referral_fees) {
            $this->commissions = $this->referral_fees->amount_money;
        }
    }
    public function submit()
    {
        $this->validate([
            "amount_money" => "required|numeric",
            "min_amount" => "required|numeric",
        ]);
        if ($this->widthdrawal_fees) {
            $this->widthdrawal_fees->amount_money = $this->amount_money;
            $this->widthdrawal_fees->min_amount = $this->min_amount;
            $this->widthdrawal_fees->save();
        } else {
            $widthdrawal_fees = Withdrawal_fees::create([
                'amount_money' => $this->amount_money,
                'min_amount' => $this->min_amount,
            ]);
            $widthdrawal_fees->save();
        }
        $this->dispatch('success', 'Updated successfully.');
    }
    public function updateReferral()
    {
        $this->validate([
            "commissions" => "required|numeric",
        ]);
        if ($this->referral_fees) {
            $this->referral_fees->amount_money = $this->commissions;
            $this->referral_fees->save();
        } else {
            $referral_fees = Referals::create([
                'amount_money' => $this->commissions,
            ]);
            $referral_fees->save();
        }
        $this->dispatch('success', 'Updated successfully.');
    }
    public function render()
    {
        return view('livewire.admin.settings.index-settings');
    }
}