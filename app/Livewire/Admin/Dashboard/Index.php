<?php

namespace App\Livewire\Admin\Dashboard;

use App\Models\Investor_with_plants;
use App\Models\Investors;
use App\Models\PlanModel;
use App\Models\Withdraw;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();
        $startWeek = now()->startOfWeek();
        $endWeek = now()->endOfWeek();
        $investor = null;
        // lấy ra tổng số đã tiền đầu tư.
        $total_investment_amount = Investor_with_plants::whereBetween('created_at', [$startDate, $endDate])
            ->sum('amount');
        // lấy ra tổng số tiền đã rút.
        $total_withdraw_amount = Withdraw::whereBetween('created_at', [$startDate, $endDate])->sum('amount');
        // lấy ra tổng số nhà đầu tư.
        $total_investor = Investors::get();
        // lấy ra tổng số kế hoạch.
        $total_plan = PlanModel::get();
        // lấy ra tổng số tiền đầu tư lớn nhất và investor_id
        $total_amount = DB::table('investor_with_plants')
            ->select('investor_id', DB::raw('SUM(amount) as total_amount'))
            ->where('status', '!=', 3)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('investor_id')
            ->orderByDesc('total_amount')
            ->first();
        if ($total_amount) {
            // lấy ra thông tin nhà đầu tư
            $investor = Investors::find($total_amount->investor_id);
        }
        // lấy ra tổng số đã tiền đầu tư trong 1 tuần.
        $total_expense = Investor_with_plants::where(function ($query) {
            $query->where('status', 1)
                ->orWhere('status', 2);
        })
            ->whereBetween('created_at', [$startWeek, $endWeek])
            ->sum('amount');

        // lấy ra tổng số đã tiền lợi nhuận trong 1 tuần.
        $total_profit = Investor_with_plants::where(function ($query) {
            $query->where('status', 1)
                ->orWhere('status', 2);
        })
            ->whereBetween('created_at', [$startWeek, $endWeek])
            ->sum('total_amount');

        // lấy ra tổng số đã tiền Thu nhập trong 1 tuần.
        $total_earnings = $total_profit - $total_expense;

        // lấy ra tổng số đã tiền đầu tư trong 1 tuần.
        $total_investment_amount_in_week = Investor_with_plants::whereBetween('created_at', [$startWeek, $endWeek])
            ->sum('amount');
        // lấy ra tổng số đã tiền đang chờ duyệt trong 1 tuần.
        $total_amount_in_week_pendding = Investor_with_plants::where(function ($query) {
            $query->where('status', 0);
        })
            ->whereBetween('created_at', [$startWeek, $endWeek])
            ->sum('amount');
        // lấy ra tổng số đã tiền đang chạy trong 1 tuần.
        $total_amount_in_week_running = Investor_with_plants::where(function ($query) {
            $query->where('status', 1);
        })
            ->whereBetween('created_at', [$startWeek, $endWeek])
            ->sum('amount');
        // lấy ra tổng số đã tiền đã hủy trong 1 tuần.
        $total_amount_in_week_cancel = Investor_with_plants::where(function ($query) {
            $query->where('status', 3);
        })
            ->whereBetween('created_at', [$startWeek, $endWeek])
            ->sum('amount');
        // lấy ra tổng số đã tiền đã hủy trong 1 tuần.
        $total_amount_in_week_success = Investor_with_plants::where(function ($query) {
            $query->where('status', 2);
        })
            ->whereBetween('created_at', [$startWeek, $endWeek])
            ->sum('amount');

        return view('livewire.admin.dashboard.index', [
            'total_investment_amount' => $total_investment_amount, 'total_withdraw_amount' => $total_withdraw_amount,
            'total_investor' => $total_investor, 'total_plan' => $total_plan, 'investor' => $investor, 'total_amount' => $total_amount,
            'total_expense' => $total_expense, 'total_profit' => $total_profit, 'total_earnings' => $total_earnings,
            'total_investment_amount_in_week' => $total_investment_amount_in_week, 'total_amount_in_week_running' => $total_amount_in_week_running,
            'total_amount_in_week_pendding' => $total_amount_in_week_pendding, 'total_amount_in_week_cancel' => $total_amount_in_week_cancel, 'total_amount_in_week_success' => $total_amount_in_week_success
        ]);
    }
}
