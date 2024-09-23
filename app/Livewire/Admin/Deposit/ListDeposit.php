<?php

namespace App\Livewire\Admin\Deposit;

use App\Components\UpdateBalance;
use App\Models\investor_coin;
use App\Models\Investor_with_plants;
use App\Models\Investors;
use App\Models\Wallets;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Carbon;

class ListDeposit extends Component
{
    use WithPagination;
    public $search = '';
    public $perpage = 20;
    public $from_date;
    public $wallet;
    public $to_date;
    public $deposits;
    public $currentDate;
    public $updateBalance;
    protected $listeners = [
        'success' => 'render',
    ];
    public function mount()
    {
        $this->from_date = Carbon::now()->startOfMonth()->toDateString();
        $this->to_date = Carbon::now()->endOfMonth()->toDateString();
        $this->currentDate = Carbon::now();
        $this->deposits = Investor_with_plants::where('status', 1)->get();
        $this->update_deposit($this->currentDate, $this->deposits);
    }
    public function confirm($id)
    {
        $deposit = Investor_with_plants::find($id);
        $this->wallet = Wallets::where('id', $deposit->wallet_id)->first();
        if ($deposit && $this->wallet && $deposit->type_payment !== 3) {
            $deposit->status = 1;
            $this->wallet->status = 0;
            $deposit->save();
            $this->wallet->save();
        } elseif ($deposit && $deposit->type_payment == 3) {
            $deposit->status = 2;
            $deposit->save();
            $investor = Investors::find($deposit->investor_id);
            $investor_coin = investor_coin::where('investor_id', $deposit->investor_id)->where('coin_id', $deposit->coin_id)->first();
            if (!$investor_coin) {
                $investor_coin = investor_coin::create([
                    'coin_id' => $deposit->coin_id,
                    'investor_id' => $deposit->investor_id,
                    'available_balance' => $deposit->amount,
                    'amount' => 0,
                    'status' => 1,
                ]);
            } else {
                $investor_coin->available_balance += $deposit->amount;
            }
            $investor_coin->save();
            $update = new UpdateBalance();
            $this->updateBalance = $update->updateAccountBalance($investor);
        }
        $this->dispatch('success', 'Confirm the plan successfully.');
    }
    public function cancel($id)
    {
        $deposit = Investor_with_plants::find($id);
        $investor = Investors::find($deposit->investor_id);
        $investor_coin = investor_coin::where('investor_id', $investor->id)->where('coin_id', $deposit->coin_id)->first();
        $this->wallet = Wallets::where('id', $deposit->wallet_id)->first();
        if ($deposit->status == 1 && $investor && $deposit->type_payment !== 3) {
            $deposit->status = 3;
            $investor->balance += $deposit->amount;
            $investor_coin->amount += $deposit->amount;
            $investor_coin->available_balance += $deposit->amount / $deposit->current_coin_price;
            $this->wallet->status = 0;
            $this->wallet->save();
            $investor_coin->save();
            $investor->save();
            $deposit->save();
            $this->dispatch('success', 'Cancel plan successfully.');
        } elseif ($deposit->status == 2 && $investor && $deposit->type_payment !== 3) {
            $deposit->status = 3;
            $investor->balance -= $deposit->total_amount;
            $investor_coin->amount -= $deposit->total_amount;
            $investor_coin->available_balance -= $deposit->total_amount / $deposit->current_coin_price;
            $deposit->calculate_money = 0;
            $this->wallet->status = 0;
            $this->wallet->save();
            $investor->save();
            $deposit->save();
            $this->dispatch('success', 'Cancel plan successfully.');
        } else {
            $deposit->status = 3;
            $deposit->save();
            $this->dispatch('success', 'Cancel plan successfully.');
        }
    }
    // public function runing($id)
    // {
    //     $investor_with_plants = Investor_with_plants::find($id);
    //     $investor_coin = investor_coin::where('investor_id', $investor_with_plants->investor_id)->where('coin_id', $investor_with_plants->coin_id)->first();
    //     $investor = Investors::find($investor_with_plants->investor_id);
    //     if ($investor_with_plants->status == 3 && $investor) {
    //         $investor_with_plants->status = 1;
    //         $investor->balance -= $investor_with_plants->total_amount;
    //         $investor_coin->amount -= $investor_with_plants->total_amount;
    //         $investor_coin->available_balance -= $investor_with_plants->total_amount / $investor_with_plants->current_coin_price;
    //         $investor_with_plants->calculate_money = 0;
    //         $investor->save();
    //         $investor_coin->save();
    //         $investor_with_plants->save();
    //         $this->dispatch('success', 'Update successfully.');
    //     }
    // }
     public function update_deposit($currentDate, $deposits)
    {
        foreach ($deposits as $key => $value) {
            $purchase_date = Carbon::parse($value->created_at);
            $end_date = $purchase_date->addDays($value->number_days)->format('Y-m-d H:i:s');
            $investor = Investors::find($value->investor_id);
            $investor_coin = investor_coin::where('investor_id', $value->investor_id)->where('coin_id', $value->coin_id)->first();
            if ($currentDate->gte($end_date) && $value->status == 1 && $investor_coin && $investor) {
                $investor_coin->available_balance += $value->total_amount;
                $value->status == 2;
                $value->save();
                $investor_coin->save();
                $update = new UpdateBalance();
                $this->updateBalance = $update->updateAccountBalance($investor);
            }
        }
    }
    public function render()
    {
        $list_deposit = DB::table('investor_with_plants')
            ->join('investors', 'investor_with_plants.investor_id', '=', 'investors.id')
            ->leftJoin('plan_models', 'investor_with_plants.plan_id', '=', 'plan_models.id')
            ->select('investor_with_plants.*', 'investors.fullname as investor_name', 'plan_models.name as plan_name', 'plan_models.title as plan_title', 'plan_models.discount as plan_discount')
            ->where(function ($query) {
                if ($this->search) {
                    $query->where('investors.fullname', 'like', '%' . $this->search . '%')
                        ->orWhere('investor_with_plants.name_coin', 'like', '%' . $this->search . '%')
                        ->orWhere('plan_models.name', 'like', '%' . $this->search . '%');
                }
            })
            ->where(function ($query) {
                if ($this->from_date) {
                    $query->where('investor_with_plants.created_at', '>=', $this->from_date);
                }
                if ($this->to_date) {
                    $query->where('investor_with_plants.created_at', '<', date('Y-m-d', strtotime($this->to_date) + 86400));
                }
            })
            ->orderBy('created_at', 'desc')
            ->paginate($this->perpage);

        return view('livewire.admin.deposit.list-deposit', ['list_deposit' => $list_deposit]);
    }
}