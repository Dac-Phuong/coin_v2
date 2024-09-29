<?php

namespace App\Livewire\Web\Home;

use App\Models\Coin_model;
use App\Models\Network;
use App\Models\plan_number_days;
use App\Models\PlanModel;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Index extends Component
{
    public $plan_fixeds;
    public $plan_daily;
    public $investor;
    public $network;
    public $coins;
    public $coin_id;
    public function mount()
    {
        $this->investor = session()->get("investor");
        $this->coins = Coin_model::where('status', 0)->get();
        $this->plan_daily = PlanModel::where('package_type', 0)->get();
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
            if ($coin) {
                $plan_fixeds = DB::table('plan_models')
                    ->join('coin_models', 'plan_models.coin_id', '=', 'coin_models.id')
                    ->where('plan_models.package_type', 1)
                    ->where('plan_models.coin_id', $this->coin_id)
                    ->select('plan_models.*', 'coin_models.coin_price as coin_price', 'coin_models.coin_name as coin_name', 'coin_models.coin_decimal as coin_decimal')
                    ->get();
            }
        }
        $this->network = Network::where('status', 0)->get();
        foreach ($plan_fixeds as $key => $item) {
            $number_profit = plan_number_days::where('plan_id', $item->id)->get();
            $item->number_profit = $number_profit;
        }
        $this->plan_fixeds = $plan_fixeds;

        return view('livewire.web.home.index')->extends('web.layouts.master')->section('content');
    }
}