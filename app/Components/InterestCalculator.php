<?php

namespace App\Components;

use App\Models\Coin_model;
use App\Models\investor_coin;
use App\Models\Investor_with_plants;
use App\Models\Investors;
use App\Models\Referal_detail;
use App\Models\Referals;
use App\Models\User;
use App\Models\Wallets;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class InterestCalculator
{
    public $interval;
    public $check = true;
    protected function getInvestorPlansFixed($investor)
    {
        return DB::table('investor_with_plants')
            ->join('investors', 'investor_with_plants.investor_id', '=', 'investors.id')
            ->join('plan_models', 'investor_with_plants.plan_id', '=', 'plan_models.id')
            ->select('plan_models.*', 'investor_with_plants.id as Investor_with_plants_id', 'investor_with_plants.current_coin_price as current_coin_price', 'investor_with_plants.coin_id as coin_id', 'investor_with_plants.number_days as number_days', 'investor_with_plants.profit as profit', 'investor_with_plants.id as Investor_with_plants_id', 'investor_with_plants.total_last_seconds as total_last_seconds', 'investor_with_plants.created_at as purchase_date', 'investor_with_plants.status as Investor_with_plants_status', 'investor_with_plants.total_amount as total_amount', 'investor_with_plants.amount as amount', 'investors.fullname as investor_name', 'plan_models.name as plan_name', 'plan_models.title as plan_title', 'plan_models.discount as plan_discount', 'plan_models.to_date as to_date', 'plan_models.from_date as start_date')
            ->where('investor_id', $investor->id)
            ->where('package_type', 1)
            ->where('investor_with_plants.status', '!=', 3)
            ->get();
    }
    public function calculator_interest($investor)
    {
        $this->calculatorInterestPlanFixed($investor);
        $this->check_referal($investor);
        $this->updateStatusWallet();
        $this->updateAccountBalance($investor);
       
    }
    // tính toán gói cố định
    public function calculatorInterestPlanFixed($investor)
    {
        $currentDate = Carbon::now();
        $list_plan = $this->getInvestorPlansFixed($investor);
        foreach ($list_plan as $plan) {
            $purchase_date = Carbon::parse($plan->purchase_date);
            $to_date = Carbon::parse($plan->to_date);
            $investor_coin = investor_coin::where('coin_id', $plan->coin_id)->first();
            // tính số ngày từ ngày bắt đầu đến ngày kết thúc.
            $this->interval = $purchase_date->diff($to_date);
            // thêm ngày
            $end_date = $purchase_date->addDays($plan->number_days)->format('Y-m-d H:i:s');
            // lấy ra investor_with_plants
            $investor_with_plants = Investor_with_plants::find($plan->Investor_with_plants_id);
            // tính số giây hiện tại đến khi kết thúc
            $curent_seconds = $currentDate->diffInSeconds($plan->purchase_date);
            // kiểm tra $curent_date nằm trong khoảng $start_date đến $end_date và tính theo gói cố định.
            if ($currentDate->greaterThanOrEqualTo(Carbon::parse($plan->purchase_date)) && $currentDate->lessThanOrEqualTo($end_date) && $plan->type_date == 0 && $plan->package_type == 1 && $plan->Investor_with_plants_status == 1) {
                $this->check = false;
                // tính lại số giây mới
                $new_seconds = $curent_seconds - $investor_with_plants->total_last_seconds;
                // tính số giây mới * với số tiền và lưu lại 
                // dd(86400 * ((((($plan->profit) / 100) * ($plan->amount * $plan->current_coin_price)) / $plan->number_days) / 24 / 60 / 60));
                $investor->balance += $new_seconds * ((((($plan->profit) / 100) * ($plan->amount * $plan->current_coin_price)) / $plan->number_days) / 24 / 60 / 60);
                // tính số giây mới * với số tiền và lưu lại vào investor_with_plants
                $investor_with_plants->calculate_money += $new_seconds * (((($plan->profit / 100) * ($plan->amount * $plan->current_coin_price)) / $plan->number_days) / 24 / 60 / 60);
                // tính số giây mới * với số tiền và lưu lại 
                $investor->earned_toatl += $new_seconds * (((($plan->profit / 100) * ($plan->amount * $plan->current_coin_price)) / $plan->number_days) / 24 / 60 / 60);
                // lưu lại số giây mới
                $investor_with_plants->total_last_seconds = $curent_seconds;
                $investor_with_plants->save();
                $investor->save();
            } elseif ($currentDate->gte($end_date) && $plan->package_type == 1 && $plan->Investor_with_plants_status == 1) {
                // cộng lại số tiền đã gửi.
                $investor->balance += ($plan->amount * $plan->current_coin_price);
                // thay đổi trạng thái sang hoàn thành.
                $investor_with_plants->status = 2;
                // lưu lại.
                $investor->save();
                $investor_with_plants->save();
                if ($investor_coin) {
                    $investor_coin->available_balance += $plan->total_amount;
                    $investor_coin->status = 1;
                    $investor_coin->save();
                    $this->updateAccountBalance($investor);
                }
                $this->check = true;
            } elseif ($currentDate->gte($end_date) && $plan->package_type == 1 && $plan->Investor_with_plants_status == 2) {
                $query = investor_coin::where('coin_id', $plan->coin_id)->where('status', 0)->first();
                if ($query) {
                    $query->available_balance += $plan->total_amount;
                    $query->status = 1;
                    $query->save();
                    $this->updateAccountBalance($investor);
                }
                $this->check = true;
            }
            // tính toán lại
            $investor_with_plants = Investor_with_plants::find($plan->Investor_with_plants_id);
            // $this->recalculationPlanFixed($plan, $investor_with_plants, $end_date, $investor, $currentDate);
        }
    }
    public function updateAccountBalance($investor)
    {
        if ($this->check) {
            $total_balance = DB::table('investor_coins')
                ->join('coin_models', 'investor_coins.coin_id', '=', 'coin_models.id')
                ->where('investor_coins.investor_id', $investor->id)
                ->sum(DB::raw('investor_coins.available_balance * coin_models.coin_price'));
            $investor->balance = $total_balance;
            $investor->save();
        }
    }
   
    protected function recalculationPlanFixed($plan, $investor_with_plants, $end_date, $investor, $currentDate)
    {
        if ($currentDate->gte($end_date) && $plan->type_date == 0 && $plan->package_type == 1 && $investor_with_plants->status == 2) {
            $profit_money = $investor_with_plants->total_amount - $investor_with_plants->amount;
            // kiểm tra nếu số giây đã tính ở trên còn thiếu.
            if ($profit_money > $investor_with_plants->calculate_money) {
                // tính số giây còn thiếu 
                $missing_amount = $profit_money - $investor_with_plants->calculate_money;
                // cộng lại số tiền còn thiếu.
                $investor_with_plants->calculate_money += $missing_amount;
                //  cộng lại số tiền còn thiếu,
                $investor->earned_toatl += $missing_amount;
                //  cộng lại số tiền còn thiếu,
                $investor->balance += $missing_amount;
                // lưu lại
                $investor->save();
                $investor_with_plants->save();
            } elseif ($profit_money < $investor_with_plants->calculate_money) {
                // tính số tiền bị thừa
                $missing_amount = $investor_with_plants->calculate_money - $profit_money;
                // trừ đi số tiền bị thừa.
                $investor_with_plants->calculate_money -= $missing_amount;
                //  trừ đi số tiền bị thừa.
                $investor->earned_toatl -= $missing_amount;
                //   trừ đi số tiền bị thừa.
                $investor->balance -= $missing_amount;
                // lưu lại
                $investor->save();
                $investor_with_plants->save();
            }
        }
    }
    public function check_referal($investor)
    {
        $referal = Referals::first();
        $referal_details = Referal_detail::where('parent_code', $investor->referal_code)->where('status', 0)->get();
        foreach ($referal_details as $item) {
            $investor_with_plants = Investor_with_plants::where('investor_id', $item->investor_id)->where('status', 1)->first();
            if ($investor_with_plants && $referal) {
                $coin_model = Coin_model::find($investor_with_plants->coin_id);
                $item->amount_received += $investor_with_plants->amount * ($referal->amount_money / 100);
                $item->coin_id = $coin_model->id;
                $item->status = 1;
                $item->save();
                if ($coin_model) {
                    $investor_coin = investor_coin::where('investor_id', $investor->id)->where('coin_id', $coin_model->id)->first();
                    if ($investor_coin) {
                        $investor_coin->available_balance += $investor_with_plants->amount * ($referal->amount_money / 100);
                    } else {
                        $investor_coin = investor_coin::create([
                            'coin_id' => $coin_model->id,
                            'investor_id' => $investor->id,
                            'available_balance' => $investor_with_plants->amount * ($referal->amount_money / 100),
                            'amount' => 0,
                            'status' => 1,
                        ]);
                    }
                    $investor_coin->save();
                }
            }
        }
        $investor->save();
    }
    public function updateStatusWallet()
    {
        Wallets::where('status', 1)->get()->each(function ($wallet) {
            if (!Investor_with_plants::where('plan_id', $wallet->plan_id)->where('status', 0)->first()) {
                $wallet->update(['status' => 0]);
            }
        });
    }
}