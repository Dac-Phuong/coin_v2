<?php

namespace App\Livewire\Admin\Withdraw;

use App\Models\Coin_model;
use App\Models\investor_coin;
use App\Models\Investors;
use App\Models\Withdraw;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use App\Models\Withdrawal_fees;

class ListWithdraw extends Component
{
    public $perpage = 20;
    public $search = '';
    public $from_date;
    public $to_date;
    public function mount()
    {
        $this->from_date = Carbon::now()->startOfMonth()->toDateString();
        $this->to_date = Carbon::now()->endOfMonth()->toDateString();
    }
    public function comfirm_withdraw($id)
    {
        $withdraw = Withdraw::find($id);
        if ($withdraw && $withdraw->status == 0) {
            $withdraw->status = 1;
            $withdraw->save();
            $this->dispatch('success', 'Confirm successful withdrawal.');
        } else {
            $this->dispatch('error', 'The investor has canceled the withdrawal.');
        }
    }
    public function cancel($id)
    {
        $cancel_withdraw = Withdraw::find($id);
        $investor = Investors::find($cancel_withdraw->investor_id);
        $investor_coin = investor_coin::where('investor_id', $investor->id)->where('coin_id', $cancel_withdraw->coin_id)->first();
        $fee_withdraw = Withdrawal_fees::first();
        if ($fee_withdraw) {
            if ($cancel_withdraw->status == 0 || $cancel_withdraw->status == 1) {
                $cancel_withdraw->status = 2;
                $investor->balance += $cancel_withdraw->total_amount * $cancel_withdraw->old_coin_price;
                $investor_coin->amount += $cancel_withdraw->total_amount * $cancel_withdraw->old_coin_price;
                $investor_coin->available_balance += $cancel_withdraw->total_amount;
                $investor->save();
                $cancel_withdraw->save();
                $this->dispatch('success', 'Withdrawal successfully canceled.');
            } else {
                $cancel_withdraw->status = 2;
                $cancel_withdraw->save();
                $this->dispatch('success', 'Withdrawal successfully canceled.');
            }
        } else {
            $this->dispatch('error', 'Please add withdrawal fee.');
        }
    }
    public function success($id)
    {
        $cancel_withdraw = Withdraw::find($id);
        $investor = Investors::find($cancel_withdraw->investor_id);
        $coin = Coin_model::find($cancel_withdraw->coin_id);
        $investor_coin = investor_coin::where('investor_id', $investor->id)->where('coin_id', $cancel_withdraw->coin_id)->first();
        $fee_withdraw = Withdrawal_fees::first();
        if ($fee_withdraw && $cancel_withdraw->status == 2) {
            $cancel_withdraw->status = 1;
            $investor->balance -= ($cancel_withdraw->amount * $cancel_withdraw->old_coin_price) + ($coin->coin_fee * $cancel_withdraw->old_coin_price);
            $investor_coin->amount -= ($cancel_withdraw->amount * $cancel_withdraw->old_coin_price) + ($coin->coin_fee * $cancel_withdraw->old_coin_price);
            $investor_coin->available_balance -= $cancel_withdraw->total_amount;
            $investor->save();
            $cancel_withdraw->save();
            $this->dispatch('success', 'Update successfully.');
        } else {
            $this->dispatch('error', 'Please add withdrawal fee.');
        }
    }
    public function render()
    {
        $list_withdraw = DB::table('withdraws')
            ->join('investors', 'withdraws.investor_id', '=', 'investors.id')
            ->select('withdraws.*', 'investors.fullname as fullname')
            ->where(function ($query) {
                if ($this->search) {
                    $query->where('investors.fullname', 'like', '%' . $this->search . '%')
                        ->orWhere('withdraws.amount', 'like', '%' . $this->search . '%');
                }
            })
            ->where(function ($query) {
                if ($this->from_date) {
                    $query->where('withdraws.created_at', '>=', $this->from_date);
                }
                if ($this->to_date) {
                    $query->where('withdraws.created_at', '<=', date('Y-m-d', strtotime($this->to_date) + 86400));
                }
            })
            ->orderBy('created_at', 'desc')
            ->paginate($this->perpage);
        return view('livewire.admin.withdraw.list-withdraw', ['list_withdraw' => $list_withdraw]);
    }
}