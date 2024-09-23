<?php

namespace App\Livewire\Web\Deposit;

use App\Components\UpdateBalance;
use App\Models\investor_coin;
use App\Models\Investor_with_plants;
use App\Models\Investors;
use App\Models\Wallets;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class ConfirmModal extends Component
{
    public $calculator;
    public $updateBalance;
    public $investor_with_plans;
    public $loading = true;
    public $plan;
    public $wallet;
    public $investor;
    public $number_days;
    public $investor_coin;
    public $curent_profit = 0;
    public $termination_fee = 0;
    protected $listeners = ['update' => 'mount'];

    public function mount($id = null)
    {
        $this->loading = true;
        $data_investor = session()->get('investor');
        if (!$data_investor) {
            return $this->redirect('/login', navigate: true);
        }
        $this->investor = Investors::find($data_investor->id);
        $this->investor_with_plans = Investor_with_plants::find($id);
        if ($this->investor_with_plans) {
            $this->investor_coin = investor_coin::where('investor_id', $this->investor->id)->where('coin_id', $this->investor_with_plans->coin_id)->first();
            $this->plan = DB::table('plan_models')
                ->join('coin_models', 'plan_models.coin_id', '=', 'coin_models.id')
                ->select('plan_models.*', 'coin_models.coin_name as coin_name')
                ->where('plan_models.id', $this->investor_with_plans->plan_id)->first();
            $this->wallet = Wallets::where('id', $this->investor_with_plans->wallet_id)->first();
            $this->loading = false;
        }
        $this->loading = false;
    }

    public function confirm_cancel()
    {
        $investor_coin = investor_coin::where('investor_id', $this->investor->id)->where('coin_id', $this->investor_with_plans->coin_id)->first();
        if ($this->investor_with_plans && $this->plan) {
            if ($this->investor_with_plans->status == 1) {
                $investor_coin->available_balance += ($this->investor_with_plans->amount - $this->plan->termination_fee);
                $investor_coin->save();
                $update = new UpdateBalance();
                $this->updateBalance = $update->updateAccountBalance($this->investor);
            }
            if ($this->wallet) {
                $this->wallet->status = 0;
                $this->wallet->save();
            }
            $this->investor_with_plans->status = 3;
            $this->investor_with_plans->save();
            $this->dispatch('success', 'T');
        } else {
            if ($this->investor_with_plans && $this->investor_with_plans->type_payment == 3) {
                $this->investor_with_plans->status = 3;
                $this->investor_with_plans->save();
                $this->dispatch('success', 'T');
            }
        }
    }
    public function render()
    {
        return view('livewire.web.deposit.confirm-modal');
    }
}