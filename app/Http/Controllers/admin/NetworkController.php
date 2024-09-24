<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Network;
use App\Models\PlanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class NetworkController extends Controller
{
    public $model;
    function __construct()
    {
        $this->model = new Network();
    }
    public function index()
    {
        $plan = PlanModel::get();
        $network = Network::get();
        return view("admin.network.index", ['plan' => $plan, 'network' => $network]);
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
                $q->where('network_name', 'like', '%' . $search . '%')
                    ->orWhere('network_price', 'like', '%' . $search . '%');
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
                'can_update' => Gate::allows('update-network'),
                'can_delete' => Gate::allows('delete-network'),
                'can_view' => true,
            ],
        ];
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'network_name' => 'required|regex:/^[a-zA-Z0-9\s.,_-]+$/',
            'network_price' => 'required|numeric',
            'network_image' => 'required|image|max:2048',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error_code' => 1,
                'error' => $validator->errors()->first()
            ]);
        }
        $data = $request->all();
        try {
            Network::create([
                'network_name' => $data['network_name'],
                'network_image' => $this->saveImage($data),
                'network_price' => $data['network_price'],
                'description' => $data['description'],
                'status' => $data['status'],
            ]);
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
        $data = $request->all();
        $validator = Validator::make($request->all(), [
            'network_name' => 'required|regex:/^[a-zA-Z0-9\s.,_-]+$/',
            'network_price' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error_code' => 0,
                'error' => $validator->errors()->first()
            ]);
        }
        try {
            $network = Network::find($data['id']);
            if (!$network) {
                return response()->json([
                    'error_code' => 0,
                    'error' => 'network not found'
                ]);
            }
            if (isset($data['network_image'])) {
                $network->network_image = $this->saveImage($data);
            }
            $network->network_name = $data['network_name'];
            $network->network_price = $data['network_price'];
            $network->description = $data['description'];
            $network->status = $data['status'];
            $network->save();
            return response()->json([
                'error_code' => 0,
                'message' => 'Update successfull'
            ]);
        } catch (\Throwable $th) {
            Log::error('Error creating coin: ' . $th->getMessage());

        }
    }
    public function destroy(Request $request)
    {
        $id = $request->input('id');
        $network = Network::findOrFail($id);
        if (!$network) {
            return response()->json([
                'error_code' => 1,
                'message' => 'network not found'
            ]);
        }
        if ($network->network_image) {
            Storage::delete('public/' . $network->network_image);
        }
        $network->delete();
        return response()->json([
            'error_code' => 0,
            'message' => 'Delete successful'
        ]);
    }
    public function saveImage($data)
    {
        $image = $data['network_image'];
        $ext = $image->extension();
        $imageName = time() . '-image.' . $ext;
        $imagePath = 'uploads/' . $imageName;
        $image->storeAs('public', $imagePath);
        $imageUrl = Storage::url($imagePath);
        return $imageUrl;
    }
}
