<?php

namespace App\Http\Controllers\admin;

use App\Components\UpdateBalance;
use App\Http\Controllers\Controller;
use App\Models\Coin_model;
use App\Models\investor_coin;
use App\Models\Investor_with_plants;
use App\Models\Investors;
use App\Models\Withdraw;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class InvestorController extends Controller
{
    public $model;
    public $investor_with_plants;
    function __construct()
    {
        $this->model = new Investors();
        $this->investor_with_plants = new Investor_with_plants();
    }

    public function index()
    {
        $coin_model = Coin_model::get();
        return view("admin.investors.index", ["coin_model" => $coin_model]);
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
        // Search
        $search = $data['search']['value'] ?? '';
        if (isset($search)) {
            $query = $query->where(function ($q) use ($search) {
                $q->where('username', 'like', '%' . $search . '%')
                    ->orWhere('fullname', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
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
                'can_update' => Gate::allows('update-investor'),
                'can_delete' => Gate::allows('delete-investor'),
                'can_create' => Gate::allows('create-investor'),
                'can_deposit' => true,
                'can_withdraw' => true,
            ],
        ];
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fullname' => 'required|string|min:3',
            'username' => 'required|string|min:3|regex:/^[a-zA-Z0-9]+$/',
            'email' => 'required|email|unique:investors,email',
            'password' => 'required|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 401);
        }
        $data = $request->all();
        $result = Investors::create([
            'fullname' => $data['fullname'],
            'username' => $data['username'],
            'email' => $data['email'],
            'status' => $data['status'],
            'balance' => 0,
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make($data['password']),
        ]);
        return response()->json($result ? 0 : 1);
    }
    public function update(Request $request)
    {
        $data = $request->all();
        $id = $request->get('id');
        $investor_coin = null;
        $validator = Validator::make($request->all(), [
            'fullname' => 'required|string|min:3',
            'username' => 'required|string|min:3|regex:/^[a-zA-Z0-9]+$/',
            'email' => ['required', 'email', Rule::unique('investors')->ignore($id)],
            'password' => 'nullable|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 401);
        }

        $investor = Investors::find($data['id']);
        if (!$investor) {
            return response()->json(['error' => 'investor not found'], 0);
        }
        if ($data['coin_id']) {
            $investor_coin = investor_coin::where('investor_id', $investor->id)->where('coin_id', $data['coin_id'])->first();
            if ($investor_coin) {
                $investor_coin->available_balance += $data['account_balance'];
            } else {
                $investor_coin = investor_coin::create([
                    'coin_id' => $data['coin_id'],
                    'investor_id' => $investor->id,
                    'amount' => 0,
                    'available_balance' => $data['account_balance'],
                    'status' => 1,
                ]);
            }
            $investor_coin->save();
        }
        if ($data['password']) {
            $investor->password = Hash::make($data['password']);
        }
        $investor->fullname = $data['fullname'];
        $investor->username = $data['username'];
        $investor->email = $data['email'];
        $investor->status = $data['status'];
        $investor->save();
        $updateBalance = new UpdateBalance();
        $updateBalance->updateAccountBalance($investor);
        return response()->json([
            'error_code' => 0,
            'message' => 'Update successfull'
        ]);
    }
    public function show(Request $request)
    {
        $id = $request->input('id');
        $investor = Investors::find($id);
        $list_wallets = null;
        if ($investor) {
            $total_deposit = Investor_with_plants::where('investor_id', $investor->id)->where('status', '!=', '3')->sum('amount');
            $total_widthdraw = Withdraw::where('investor_id', $investor->id)->where('status', 1)->sum('amount');
            $list_wallets = DB::table('investor_wallets')
                ->join('networks', 'networks.id', '=', 'investor_wallets.network_id')
                ->select('investor_wallets.*', 'networks.network_name as network_name')
                ->where('investor_id', $investor->id)
                ->get();
        }
        return response()->json([
            'error_code' => 0,
            'message' => 'Get detail successful',
            'data' => [
                'investor' => $investor,
                'total_deposit' => $total_deposit ?? 0,
                'total_widthdraw' => $total_widthdraw ?? 0,
                'list_wallets' => $list_wallets ?? []
            ]
        ]);
    }
    public function destroy(Request $request)
    {
        $id = $request->input('id');
        $investor = Investors::findOrFail($id);
        if (!$investor) {
            return response()->json([
                'error_code' => 1,
                'message' => 'investor not found'
            ]);
        }
        $investor->delete();

        return response()->json([
            'error_code' => 0,
            'message' => 'Delete successful'
        ]);
    }
    public function historyDeposit($id)
    {
        return view("admin.investors.history.deposit", ['id' => $id]);
    }
    public function depositDataTable(Request $request)
    {
        $data = $request->all();
        // Page Length
        $pageLength = 6;
        $pageNumber = $data['page'] ?? 1;
        $skip = ($pageNumber - 1) * $pageLength;
        $query = $this->investor_with_plants->query();
        $recordsTotal = $query->count();
        $result = $query
            ->join('investors', 'investor_with_plants.investor_id', '=', 'investors.id')
            ->join('plan_models', 'investor_with_plants.plan_id', '=', 'plan_models.id')
            ->select('plan_models.*', 'investor_with_plants.id as Investor_with_plants_id', 'investor_with_plants.number_days as number_days', 'investor_with_plants.name_coin as name_coin', 'investor_with_plants.status as investor_with_plants_status', 'investor_with_plants.amount as amount', 'investor_with_plants.total_amount as total_amount', 'investor_with_plants.created_at as start_date', 'investors.fullname as investor_name', 'plan_models.name as plan_name', 'plan_models.title as plan_title', 'investor_with_plants.profit as plan_discount')
            ->orderBy('created_at', 'DESC')
            ->where('investor_id',$data['investor_id'])
            ->skip($skip)
            ->take($pageLength)
            ->get();
        $pageCount = ceil($recordsTotal / $pageLength);
        return [
            'result' => $result,
            'page_count' => $pageCount,
        ];
    }

    public function history_withdraw($id)
    {
        return view("admin.investors.history.withdraw", ['id' => $id]);
    }
}
