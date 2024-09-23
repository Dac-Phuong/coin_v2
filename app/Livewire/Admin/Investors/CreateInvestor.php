<?php

namespace App\Livewire\Admin\Investors;

use App\Models\Investors;
use App\Models\Wallets;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class CreateInvestor extends Component
{
    public $fullname;
    public $wallets;
    public $username;
    public $status;
    public $account_balance;
    public $email;
    public $phone;
    public $password;

    public function submit()
    {
        $this->validate(
            [
                'fullname' => 'required|string|min:3',
                'username' => 'required|string|min:3|regex:/^[a-zA-Z0-9]+$/',
                'email' => 'required|email|unique:investors,email',
                'password' => 'required|min:6',
            ]
        );
        $investors = Investors::create([
            'fullname' => $this->fullname,
            'username' => $this->username,
            'email' => $this->email,
            'status' => $this->status,
            'balance' => 0,
            'password' => Hash::make($this->password),
        ]);
        $investors->save();
        $this->dispatch('success', 'Successfully added new investors.');
        $this->reset();
    }
    public function render()
    {
        return view('livewire.admin.investors.create-investor');
    }
    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }
}