<?php

namespace App\Livewire\Web\Deposit;

use App\Components\InterestCalculator;
use App\Models\Investors;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class ListDeposit extends Component
{
    use WithPagination;
    #[Title('List Deposit')]
    public $investor;
    public $ref;
    public $plan;
    public $interestCalculator;
    public $curent_profit = 0;
    public $id;
    protected $listeners = [
        'success' => 'render',
    ];

    public function render()
    {
        $data_investor = session()->get("investor");
        $this->investor = Investors::find($data_investor ? $data_investor->id : '');

        if (is_null($this->investor) || $this->investor->status == "1") {
            return $this->redirect('/login', ['navigate' => true]);
        }
        $ref = url()->to('/');
        if ($ref && $this->investor) {
            $this->ref = $ref . '/register?ref=' . $this->investor->referal_code;
        }

        $list_deposit = DB::table('investor_with_plants')
            ->join('investors', 'investor_with_plants.investor_id', '=', 'investors.id')
            ->leftJoin('plan_models', 'investor_with_plants.plan_id', '=', 'plan_models.id')
            ->select('plan_models.*', 'investor_with_plants.id as Investor_with_plants_id', 'investor_with_plants.number_days as number_days', 'investor_with_plants.name_coin as name_coin', 'investor_with_plants.current_coin_price as current_coin_price', 'investor_with_plants.status as investor_with_plants_status', 'investor_with_plants.amount as amount', 'investor_with_plants.total_amount as total_amount', 'investor_with_plants.created_at as start_date', 'investors.fullname as investor_name', 'plan_models.name as plan_name', 'plan_models.title as plan_title', 'investor_with_plants.profit as plan_discount')
            ->where('investor_id', $this->investor->id)
            ->orderBy('start_date', 'desc')
            ->paginate(10);
        $calculator = new InterestCalculator();
        $this->interestCalculator = $calculator->calculator_interest($this->investor);
        return view('livewire.web.deposit.list-deposit', ['list_deposit' => $list_deposit])->extends('components.layouts.app')->section('content');
    }
}