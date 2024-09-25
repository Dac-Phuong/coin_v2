<?php

namespace App\Http\Controllers\admin;

use App\Components\UpdateBalance;
use App\Http\Controllers\Controller;
use App\Models\investor_coin;
use App\Models\Investor_with_plants;
use App\Models\Investors;
use App\Models\Wallets;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DepositController extends Controller
{
    public $model;
    function __construct()
    {
        $this->model = new Investor_with_plants();
    }
    public function index()
    {
        $deposits = Investor_with_plants::where('status', 1)->get();
        $this->updateDeposit($deposits);
        return view("admin.deposit.index");
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
        $query->leftJoin('plan_models', 'investor_with_plants.plan_id', '=', 'plan_models.id')
            ->leftJoin('investors', 'investor_with_plants.investor_id', '=', 'investors.id')
            ->select('investor_with_plants.*', 'investors.fullname as investor_name', 'plan_models.name as plan_name', 'plan_models.title as plan_title', 'plan_models.discount as plan_discount');
        // Search
        $search = $data['search']['value'] ?? '';
        if (!empty($search)) {
            $query = $query->where(function ($q) use ($search) {
                $q->where('investors.fullname', 'like', '%' . $search . '%')
                    ->orWhere('plan_models.name', 'like', '%' . $search . '%')
                    ->orWhere('plan_models.title', 'like', '%' . $search . '%');
            });
        }
        $query = $query->orderBy($orderByColumn, $orderType);
        $recordsFiltered = $recordsTotal = $query->count();
        $result = $query
            ->orderBy('created_at', 'desc')
            ->skip($skip)
            ->take($pageLength)
            ->get();
        return [
            'draw' => $data['draw'],
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $result,
            'role' => [
                'can_update' => true,
                'can_delete' => true,
            ],
        ];
    }
    public function confirm(Request $request)
    {
        try {
            $deposit = Investor_with_plants::find($request->id);
            $wallet = Wallets::where('id', $deposit->wallet_id)->first();
            if (isset($deposit) && isset($wallet) && $deposit->type_payment !== 3) {
                $deposit->status = 1;
                $wallet->status = 0;
                $deposit->save();
                $wallet->save();
            } elseif (isset($deposit) && $deposit->type_payment == 3) {
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
                $updateBalance = new UpdateBalance();
                $updateBalance->updateAccountBalance($investor);
            }
            return response()->json([
                'error_code' => 0,
                'message' => 'Confirm successfully',
            ], 200);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'error_code' => 1,
                'message' => $th->getMessage(),
            ], 500);
        }
    }
    public function cancel(Request $request)
    {
        try {
            $deposit = Investor_with_plants::find($request->id);
            $investor = Investors::find($deposit->investor_id);
            $investor_coin = investor_coin::where('investor_id', $investor->id)->where('coin_id', $deposit->coin_id)->first();
            $wallet = Wallets::where('id', $deposit->wallet_id)->first();
            if ($deposit->status == 1 && $investor && $deposit->type_payment !== 3) {
                $investor_coin->available_balance += $deposit->amount;
                $deposit->status = 3;
                if ($wallet) {
                    $wallet->status = 0;
                    $wallet->save();
                }
            } else {
                $deposit->status = 3;
            }
            $investor_coin->save();
            $deposit->save();
            $updateBalance = new UpdateBalance();
            $updateBalance->updateAccountBalance($investor);
            return response()->json([
                'error_code' => 0,
                'message' => 'Cancel plan successfully',
            ], 200);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'error_code' => 1,
                'message' => $th->getMessage(),
            ], 500);
        }
    }
    public function updateDeposit($deposits)
    {
        $currentDate = Carbon::now();
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
                $updateBalance = new UpdateBalance();
                $updateBalance->updateAccountBalance($investor);
            }
        }
    }
}
