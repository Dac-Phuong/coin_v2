<?php

namespace App\Livewire\Web\Account;

use App\Components\InterestCalculator;
use App\Models\Coin_model;
use App\Models\investor_coin;
use App\Models\Investor_with_plants;
use App\Models\Investors;
use App\Models\Network;
use App\Models\Wallets;
use App\Models\Withdraw;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Title;
use Livewire\Component;

class Account extends Component
{
    #[Title('Account')]
    protected $interestCalculator;
    public $ref;
    public $investor;
    public $coins;
    public $investor_coin;
    public $last_deposit = null;
    public $account_balance = 0;
    public $total_withdraw = 0;
    public $pending_withdraw = 0;
    public $last_withdraw = 0;
    public $earned_toatl = 0;
    public $active_deposit = 0;
    public $active_by_package = 0;
    
    public function logout()
    {
        $investor = optional(session('investor'))->id;
        if ($investor) {
            session()->forget('investor');
        }
        return $this->redirect('/', navigate: true);
    }
    public function mount()
    {
        $data_investor = session()->get("investor");
        // lấy ra investor
        $this->investor = Investors::find($data_investor ? $data_investor->id : '');
        if (!$this->investor || $this->investor->status == "1") {
            return $this->redirect('/login', navigate: true);
        }
    }
    public function render()
    {
        // lấy referal link
        $ref = url()->to('/');
        if ($ref && $this->investor) {
            $this->ref = $ref . '/register?ref=' . $this->investor->referal_code;
        }
        $this->coins = Coin_model::get();
        // số tiền gửi cuối cùng
        $this->last_deposit = Investor_with_plants::where('investor_id', $this->investor->id)
            ->where(function ($query) {
                $query->where('status', 1)
                    ->orWhere('status', 2);
            })
            ->orderBy('created_at', 'desc')
            ->first();
        $this->total_withdraw = Withdraw::where('investor_id', $this->investor->id)->where('status', 1)->sum('amount');
        // tổng số tiền chờ rút . pending
        $this->pending_withdraw = DB::table('withdraws')
            ->join('coin_models', 'withdraws.coin_id', '=', 'coin_models.id')
            ->where('withdraws.investor_id', $this->investor->id)
            ->where('withdraws.status', 0)
            ->latest('withdraws.created_at')
            ->select('withdraws.*', 'coin_models.coin_name as name_coin')
            ->first();
        // số tiền rút cuối cùng
        $this->last_withdraw = DB::table('withdraws')
            ->join('coin_models', 'withdraws.coin_id', '=', 'coin_models.id')
            ->where('withdraws.investor_id', $this->investor->id)
            ->where('withdraws.status', 1)
            ->latest('withdraws.created_at')
            ->select('withdraws.*', 'coin_models.coin_name as name_coin')
            ->first();
        // tính lãi suất theo giây
        $calculator = new InterestCalculator();
        $this->interestCalculator = $calculator->calculator_interest($this->investor);
        // số tiền gửi đang hoạt động
        $this->active_deposit = Investor_with_plants::where('investor_id', $this->investor->id)
            ->where(function ($query) {
                $query->where('status', 0);
                $query->where('type_payment', 3);
            })
            ->first();
        $this->active_by_package = Investor_with_plants::where('investor_id', $this->investor->id)
            ->where(function ($query) {
                $query->where('status', 1);
            })
            ->first();
        $investor_coins = DB::table('investor_coins')
            ->join('coin_models', 'coin_models.id', '=', 'investor_coins.coin_id')
            ->select('investor_coins.*', 'coin_models.*')
            ->where('investor_coins.investor_id', $this->investor->id)
            ->paginate(10);
        return view('livewire.web.account.account', ['investor_coins' => $investor_coins])->extends('components.layouts.app')->section('content');
    }
}