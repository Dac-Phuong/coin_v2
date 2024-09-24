<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Network;
use App\Models\PlanModel;
use App\Models\Wallets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;

class WalletController extends Controller
{
    public $model;
    function __construct()
    {
        $this->model = new Wallets();
    }
    public function index($id)
    {
        $plan = PlanModel::get();
        $network  = Network::get();
        return view('admin.wallets.index', ['id' => $id,'plan' => $plan, 'network' => $network]);
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
            $query = $query->where(function ($query) use ($search) {
                $query->where('wallet_address', 'like', "%$search%")
                  ->orWhereHas('plan', function ($subQuery) use ($search) {
                    $subQuery->where('name', 'like', "%$search%");
                  })
                  ->orWhereHas('network', function ($subQuery) use ($search) {
                    $subQuery->where('network_name', 'like', "%$search%");
                  });
              });
        }
        $query = $query->orderBy($orderByColumn, $orderType);
        $recordsFiltered = $recordsTotal = $query->where('wallets.network_id', $data['network_id'])->count();
        $result = $query
            ->join('plan_models', 'plan_models.id', '=', 'wallets.plan_id')
            ->join('networks', 'networks.id', '=', 'wallets.network_id')
            ->select('wallets.*', 'networks.network_name as network_name', 'plan_models.name as plan_name')
            ->where('wallets.network_id', $data['network_id'])
            ->skip($skip)
            ->take($pageLength)
            ->get();
        return [
            'draw' => $data['draw'],
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $result,
            'role' => [
                'can_update' => Gate::allows('update-wallets'),
                'can_delete' => Gate::allows('delete-wallets'),
            ],
            
        ];
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'plan_id' => 'required',
            'network_id' => 'required',
            'wallet_address' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error_code' => 1,
                'error' => $validator->errors()->first()
            ]);
        }
        $data = $request->all();
        try {
            $new_array = array_filter(explode("\n", $data['wallet_address']), 'strlen');
            foreach ($new_array as $key => $address) {
                $wallets = Wallets::create([
                    'plan_id' => $data['plan_id'],
                    'network_id' => $data['network_id'],
                    'wallet_address' => $address,
                ]);
                $wallets->save();
            }
            return response()->json([
                'error_code' => 0,
                'message' => 'Create successfully'
            ]);
        } catch (\Exception $e) {
            $this->dispatch('error', $e->getMessage());
           
        }
    }
    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            'plan_id' => 'required',
            'network_id' => 'required',
            'wallet_address' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error_code' => 1,
                'error' => $validator->errors()->first()
            ]);
        }
        try {
            $data = $request->all();
            $wallets = Wallets::find($data['id']);
            if(!$wallets){
                return response()->json([
                    'error_code' => 1,
                    'message' => 'Wallets not found'
                ]);
            }
            $wallets->wallet_address = $data['wallet_address'];
            $wallets->plan_id = $data['plan_id'];
            $wallets->network_id = $data['network_id'];
            $wallets->status = $data['status'];
            $wallets->save();
            return response()->json([
                'error_code' => 0,
                'message' => 'Update successfully'
            ]);
        } catch (\Throwable $th) {
            $this->dispatch('error', $th->getMessage());
        }
    }
    public function destroy(Request $request)
    {
        $id = $request->input('id');
        $wallet = Wallets::findOrFail($id);
        if (!$wallet) {
            return response()->json([
                'error_code' => 1,
                'message' => 'wallet not found'
            ]);
        }
        $wallet->delete();
        return response()->json([
            'error_code' => 0,
            'message' => 'Delete successful'
        ]);
    }
    public function detail()
    {
        return view('admin.wallets.detail');
    }
}