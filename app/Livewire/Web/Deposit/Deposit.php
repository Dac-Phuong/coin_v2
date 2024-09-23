<?php

namespace App\Livewire\Web\Deposit;

use App\Components\autoGetRateCoin;
use App\Components\InterestCalculator;
use App\Models\Coin_model;
use App\Models\Investors;
use App\Models\plan_number_days;
use App\Models\PlanModel;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Title;
use Livewire\Component;

class Deposit extends Component
{
    #[Title('Deposit')]

    public $plan_fixeds;
    public $account_balance;
    public $plan_daily;
    public $investor;
    public $coins;
    public $coin_id;
    public $ref;
    public $interestCalculator;
    public $autoGetRateCoins;

    protected $listeners = [
        'success' => 'render',
    ];
    public function mount()
    {
        $data_investor = session()->get("investor");
        $this->investor = Investors::find($data_investor ? $data_investor->id : '');
        if (!$this->investor || $this->investor->status == "1") {
            return $this->redirect('/login', navigate: true);
        }
        $ref = url()->to('/');
        if ($ref && $this->investor) {
            $this->ref = $ref . '/register?ref=' . $this->investor->referal_code;
        }
        $this->plan_daily = PlanModel::where('package_type', 0)->get();
        $this->coins = Coin_model::where('status', 0)->get();
    }
    public function checkbox($id = null)
    {
        $this->coin_id = $id;
    }
    public function render()
    {
        if ($this->coin_id) {
            $plan_fixeds = DB::table('plan_models')
                ->join('coin_models', 'plan_models.coin_id', '=', 'coin_models.id')
                ->where('plan_models.package_type', 1)
                ->where('plan_models.coin_id', $this->coin_id)
                ->select('plan_models.*', 'coin_models.coin_price as coin_price', 'coin_models.coin_name as coin_name', 'coin_models.coin_decimal as coin_decimal')
                ->get();
        } else {
            $coin = Coin_model::first();
            $this->coin_id = $coin->id;
            $plan_fixeds = DB::table('plan_models')
                ->join('coin_models', 'plan_models.coin_id', '=', 'coin_models.id')
                ->where('plan_models.package_type', 1)
                ->where('plan_models.coin_id', $this->coin_id)
                ->select('plan_models.*', 'coin_models.coin_price as coin_price', 'coin_models.coin_name as coin_name', 'coin_models.coin_decimal as coin_decimal')
                ->get();
        }
        foreach ($plan_fixeds as $key => $item) {
            $number_profit = plan_number_days::where('plan_id', $item->id)->get();
            $item->number_profit = $number_profit;
        }
        $this->plan_fixeds = $plan_fixeds;
        $calculator = new InterestCalculator();
        $autoUpdateRateCoins = new autoGetRateCoin();
        $this->autoGetRateCoins = $autoUpdateRateCoins->updateCoinPrice();
        $this->interestCalculator = $calculator->calculator_interest($this->investor);
        $investor_coins = DB::table('investor_coins')
            ->join('coin_models', 'coin_models.id', '=', 'investor_coins.coin_id')
            ->select('investor_coins.*', 'coin_models.*')
            ->where('investor_coins.investor_id', $this->investor->id)
            ->paginate(10);

        return view('livewire.web.deposit.deposit', ['investor_coins' => $investor_coins])->extends('components.layouts.app')->section('content');
    }
}