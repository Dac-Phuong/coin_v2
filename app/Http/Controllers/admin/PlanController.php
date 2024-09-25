<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Coin_model;
use App\Models\plan_number_days;
use App\Models\PlanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PlanController extends Controller
{
    public $model;
    function __construct()
    {
        $this->model = new PlanModel();
    }
    public function index()
    {
        $coins = Coin_model::get();
        return view("admin.plans.index", ['coins' => $coins]);
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
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('title', 'like', '%' . $search . '%')
                    ->orWhere('discount', 'like', '%' . $search . '%');
            });
        }
        $query = $query->orderBy($orderByColumn, $orderType);
        $recordsFiltered = $recordsTotal = $query->count();
        $result = $query
            ->with('coins')
            ->with('planNumberDays')
            ->skip($skip)
            ->take($pageLength)
            ->get();
        return [
            'draw' => $data['draw'],
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $result,
            'role' => [
                'can_update' => Gate::allows('update-network'),
                'can_delete' => Gate::allows('delete-network'),
            ],
        ];
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:plan_models,name',
            'title' => 'required|string',
            'discount' => 'required|numeric',
            'coin_id' => 'required',
            'min_deposit' => 'required|numeric',
            'termination_fee' => 'required|numeric',
            'number_days.*.profit' => 'required|numeric',
        ], [
            'number_days.*.profit.required' => 'The profit field is required for each number of days.',
            'number_days.*.profit.numeric' => 'The profit must be a number for each number of days.',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error_code' => 1,
                'error' => $validator->errors()->first()
            ]);
        }
        try {
            $data = $request->all();
            $plan = PlanModel::create([
                'name' => $data['name'],
                'title' => $data['title'],
                'discount' => $data['discount'],
                'min_deposit' => $data['coin_id'],
                'package_type' => 1,
                'coin_id' => $data['coin_id'],
                'type_date' => $data['type_date'] ?? 0,
                'termination_fee' => $data['termination_fee'] ?? 0,
            ]);
            $plan->save();
            if ($plan) {
                foreach ($data['number_days'] as $key => $value) {
                    $number_days = plan_number_days::create([
                        'plan_id' => $plan->id,
                        'coin_id' => $data['coin_id'],
                        'number_days' => $value["days"],
                        'profit' => $value["profit"],
                    ]);
                    $number_days->save();
                }
            }
            return response()->json([
                'error_code' => 0,
                'message' => 'Create successful'
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error creating coin: ' . $e->getMessage());
        }
    }
    public function update(Request $request)
    {
        $id = $request->get('id');
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', Rule::unique('plan_models')->ignore($id)],
            'title' => 'required|string',
            'discount' => 'required|numeric',
            'coin_id' => 'required',
            'min_deposit' => 'required|numeric',
            'termination_fee' => 'required|numeric',
            'number_days.*.profit' => 'required|numeric',
        ], [
            'number_days.*.profit.required' => 'The profit field is required for each number of days.',
            'number_days.*.profit.numeric' => 'The profit must be a number for each number of days.',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error_code' => 1,
                'error' => $validator->errors()->first()
            ]);
        }
        try {
            $data = $request->all();
            $plan = PlanModel::find($data['id']);
            if (!$plan) {
                return response()->json([
                    'error_code' => 1,
                    'error' => 'network not found'
                ]);
            }
            $plan->name = $data['name'];
            $plan->title = $data['title'];
            $plan->discount = $data['discount'];
            $plan->coin_id = $data['coin_id'];
            $plan->min_deposit = $data['min_deposit'];
            $plan->termination_fee = $data['termination_fee'];
            $plan->save();
            foreach ($data['number_days'] as $value) {
                $update = plan_number_days::find($value['id'] ?? 0);
                if (isset($update)) {
                    $update->profit = $value['profit'];
                    $update->coin_id = $data['coin_id'];
                    $update->number_days = $value['days'] ; 
                    $update->save();
                } else {
                    // Create new record
                    $create = plan_number_days::create([
                        'plan_id' => $plan->id,
                        'coin_id' => $data['coin_id'],
                        'profit' => $value['profit'],
                        'number_days' => $value['days'],
                    ]);
                    $create->save();
                }
            }
            return response()->json([
                'error_code' => 0,
                'message' => 'Update successfull'
            ]);
        } catch (\Throwable $th) {
            Log::error('Error creating coin: ' . $th->getMessage());
        }
    }
    public function delete(Request $request)
    {
        $id = $request->input('id');
        $number_days = plan_number_days::findOrFail($id);
        if (!$number_days) {
            return response()->json([
                'error_code' => 1,
                'message' => 'Number days not found'
            ]);
        }
        $number_days->delete();
        return response()->json([
            'error_code' => 0,
            'message' => 'Delete successful'
        ]);
    }
    public function destroy(Request $request)
    {
        $id = $request->input('id');
        $plan = PlanModel::findOrFail($id);
        if (!$plan) {
            return response()->json([
                'error_code' => 1,
                'message' => 'plan not found'
            ]);
        }
        $plan->delete();
        return response()->json([
            'error_code' => 0,
            'message' => 'Delete successful'
        ]);
    }
}
