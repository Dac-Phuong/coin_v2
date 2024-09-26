<?php

namespace App\Http\Controllers\admin;

use App\Components\UpdateBalance;
use App\Http\Controllers\Controller;
use App\Models\Coin_model;
use App\Models\investor_coin;
use App\Models\Investors;
use App\Models\Withdraw;
use App\Models\Withdrawal_fees;
use Illuminate\Http\Request;
class WithdrawController extends Controller
{
    public $model;
    function __construct()
    {
        $this->model = new Withdraw();
    }
    public function index()
    {
        return view("admin.withdraw.index");
    }

    public function filterDataTable(Request $request)
    {
        $data = $request->all();
        // Page Length
        $pageNumber = ($data['start'] / $data['length']) + 1;
        $pageLength = $data['length'] ?? 10;
        $skip = ($pageNumber - 1) * $pageLength;
        // Page Order
        $orderColumnIndex = $data['order'][0]['column'] ?? '0';
        $orderByColumn = $data['columns'][$orderColumnIndex]['data'];
        $orderType = $data['order'][0]['dir'] ?? 'desc';
        $query = $this->model->query();
        $query->join('investors', 'withdraws.investor_id', '=', 'investors.id');
        $query->select('withdraws.*', 'investors.fullname as fullname');
        // Search
        $search = $data['search']['value'] ?? '';
        if (isset($search)) {
            $query = $query->where(function ($q) use ($search) {
                $q->where('fullname', 'like', '%' . $search . '%')
                    ->orWhere('coin_name', 'like', '%' . $search . '%')
                    ->orWhere('amount', 'like', '%' . $search . '%');
            });
        }
        $query = $query->orderBy($orderByColumn, $orderType);
        $recordsFiltered = $recordsTotal = $query->count();
        $result = $query
            ->skip($skip)
            ->take($pageLength)
            ->get();
        return [
            'draw' => $data['draw'],
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $result,
            'role' => [
                'can_confirm' => true,
                'can_cancel' => true,
            ],
        ];
    }
    public function confirm(Request $request)
    {
        try {
            $withdraw = Withdraw::find($request->id);
            $investor = Investors::find($withdraw->investor_id);
            // $coin = Coin_model::find($withdraw->coin_id);
            if (!$withdraw) {
                return response()->json([
                    'error_code' => 1,
                    'message' => 'Withdrawal not found',
                ], 404);
            }
            if ($withdraw->status == 0) {
                $withdraw->status = 1;
                $withdraw->save();
                return response()->json([
                    'error_code' => 0,
                    'message' => 'Confirm successful withdrawal.',
                ], 200);
            }
            if (isset($investor) && $withdraw->status == 2) {
                $investor_coin = investor_coin::where('investor_id', $investor->id)->where('coin_id', $withdraw->coin_id)->first();
                $investor_coin->available_balance -= $withdraw->total_amount;
                $withdraw->status = 1;
                $investor->save();
                $withdraw->save();
                $updateBalance = new UpdateBalance();
                $updateBalance->updateAccountBalance($investor);
                return response()->json([
                    'error_code' => 0,
                    'message' => 'Confirm successful withdrawal.',
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function cancel(Request $request)
    {
        try {
            $cancel_withdraw = Withdraw::find($request->id);
            $investor = Investors::find($cancel_withdraw->investor_id);
            $investor_coin = investor_coin::where('investor_id', $investor->id)->where('coin_id', $cancel_withdraw->coin_id)->first();
            if (!$investor) {
                return response()->json([
                    'error_code' => 1,
                    'message' => 'Investor not found',
                ], 404);
            }
            if (!$investor_coin) {
                return response()->json([
                    'error_code' => 1,
                    'message' => 'Investor coin not found',
                ], 404);
            }
            if ($cancel_withdraw->status == 0 || $cancel_withdraw->status == 1) {
                $cancel_withdraw->status = 2;
                $investor_coin->available_balance += $cancel_withdraw->total_amount;
                $investor_coin->save();
                $investor->save();
                $cancel_withdraw->save();
                $updateBalance = new UpdateBalance();
                $updateBalance->updateAccountBalance($investor);
                return response()->json([
                    'error_code' => 0,
                    'message' => 'Withdrawal successfully canceled.',
                ], 200);
            }
            return response()->json([
                'error_code' => 1,
                'message' => 'Withdrawal status not found',
            ], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }
}
