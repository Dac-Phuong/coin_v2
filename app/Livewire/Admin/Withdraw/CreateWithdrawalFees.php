<?php

namespace App\Livewire\Admin\Withdraw;

use App\Models\Withdrawal_fees;
use Livewire\Component;

class CreateWithdrawalFees extends Component
{
    public $amount_money;
    public $min_amount;
    public $widthdrawal_fees;
    public function mount()
    {
        $this->widthdrawal_fees = Withdrawal_fees::first();
        if ($this->widthdrawal_fees) {
            $this->amount_money = $this->widthdrawal_fees->amount_money;
            $this->min_amount = $this->widthdrawal_fees->min_amount;
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
        $this->dispatch('success', 'add a successful withdrawal fee.');
    }
    public function render()
    {
        return view('livewire.admin.withdraw.create-withdrawal-fees');
    }
}
