<?php

namespace App\Livewire\Admin\Investors;

use App\Components\UpdateBalance;
use App\Models\Coin_model;
use App\Models\investor_coin;
use App\Models\Investors;
use App\Models\Wallets;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class UpdateInvestor extends Component
{
    public $fullname;
    public $username;
    public $email;
    public $phone;
    public $password;
    public $wallet_id;
    public $account_balance = 0;
    public $status;
    public $wallet_address;
    public $investor;
    public $coin_model;
    public $coin_id;
    public $balance;
    public $updateBalance;
    protected $listeners = ['update' => 'mount'];
    public function mount($id = null)
    {
        $this->investor = Investors::find($id);
        $this->account_balance = 0;
        if ($this->investor) {
            $this->fullname = $this->investor->fullname;
            $this->username = $this->investor->username;
            $this->email = $this->investor->email;
            $this->status = $this->investor->status;
            $this->balance = $this->investor->balance;
        }
    }
    public function submit()
    {
        $this->validate(
            [
                'fullname' => 'required|string|',
                'email' => 'required|email',
                'account_balance' => 'nullable|numeric',

            ]
        );
       if ($this->coin_id && $this->account_balance) {
            $this->coin_model = Coin_model::find($this->coin_id);
            $investor_coin = investor_coin::where('investor_id', $this->investor->id)->where('coin_id', $this->coin_model->id)->first();
            $this->investor->balance += $this->account_balance * $this->coin_model->coin_price;
            if ($investor_coin) {
                $investor_coin->available_balance += $this->account_balance;
            } else {
                $investor_coin = investor_coin::create([
                    'coin_id' => $this->coin_model->id,
                    'investor_id' => $this->investor->id,
                    'amount' => 0,
                    'available_balance' => $this->account_balance,
                    'status' => 1,
                ]);
            }
            $investor_coin->save();
            $this->investor->save();
            $update = new UpdateBalance();
            $this->updateBalance = $update->updateAccountBalance($this->investor);
        } 
        $this->investor->username = $this->username;
        $this->investor->fullname = $this->fullname;
        $this->investor->email = $this->email;
        $this->investor->status = $this->status;
        if ($this->password) {
            $this->investor->password = Hash::make($this->password);
        }
        $this->investor->save();
        $this->dispatch('success', 'Update invester successfully.');
    }
   
    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }
    public function render()
    {
        $this->coin_model = Coin_model::where('status', 0)->get();

        return view('livewire.admin.investors.update-investor');
    }
}