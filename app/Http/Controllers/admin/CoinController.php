<?php

namespace App\Http\Controllers\admin;

use App\Components\autoGetRateCoin;
use App\Http\Controllers\Controller;
use App\Models\Coin_model;
use App\Models\Network;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CoinController extends Controller
{
    public $model;
    function __construct()
    {
        $this->model = new Coin_model();
    }

    public function index()
    {
        $autoUpdateRateCoins = new autoGetRateCoin();
        $autoUpdateRateCoins->updateCoinPrice();
        $network = Network::where('status',0)->get();
        return view("admin.coin.index",['network'=>$network]);
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
        // Thêm sắp xếp vào truy vấn
        $coins = $this->model->orderBy($orderByColumn, $orderType)->get(); 
        foreach ($coins as $key => $value) {
            $array_id = array_filter(explode(',', str_replace(['[', ']', '"'], '', $value->network_id)));
            $network_names = Network::whereIn('id', $array_id)->pluck('network_name')->toArray();
            $coins[$key]['network_name'] = $network_names;
        }

        $search = $data['search']['value'] ?? '';
        if (isset($search)) {
            $coins = $coins->filter(function ($coin) use ($search) {
                return stripos($coin->coin_name, $search) !== false ||
                       stripos($coin->coin_price, $search) !== false ||
                       stripos($coin->coin_fee, $search) !== false;
            });
        }
        $recordsFiltered = $recordsTotal = $coins->count();
        $result = $coins->skip($skip)->take($pageLength)->values(); 
        return [
            'draw' => $data['draw'],
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $result,
            'role' => [
                'can_update' => Gate::allows('update-coin'),
                'can_delete' => Gate::allows('delete-coin'),
            ],
        ];
    }
   
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'coin_name' => 'required|regex:/^[a-zA-Z0-9\s.,_-]+$/',
            'coin_price' => 'required',
            'coin_fee' => 'required',
            'min_withdraw' => 'required',
            'coin_decimal' => 'required',
            'coin_image' => 'required|image|max:2048',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error_code' => 1,
                'error' => $validator->errors()->first()
            ]);
        }
        $data = $request->all();
        try {
            Coin_model::create([
                'coin_name' => $data['coin_name'],
                'coin_price' => $data['coin_price'],
                'coin_decimal' => $data['coin_decimal'],
                'rate_coin' => $data['rate_coin'] ?? 0, 
                'min_withdraw' => $data['min_withdraw'],
                'coin_fee' => $data['coin_fee'],
                'coin_image' => $this->saveImage($data),
                'network_id' => json_encode($data['network_id']),
                'status' => $data['status'],
            ]);
            return response()->json([
                'error_code' => 0,
                'message' => 'Create successful'
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error creating coin: ' . $e->getMessage());
            return response()->json([ 
                'error_code' => 1,
                'message' => 'Error creating coin'
            ], 500);
        }
    }
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'coin_name' => 'required|regex:/^[a-zA-Z0-9\s.,_-]+$/',
            'coin_price' => 'required',
            'coin_decimal' => 'required',
            'min_withdraw' => 'required',
            'coin_fee' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error_code' => 1,
                'error' => $validator->errors()->first()
            ]);
        }
       try {
            $data = $request->all();
            $coin = Coin_model::find($data['id']);
            if (!$coin) {
                return response()->json([
                    'error_code' => 1,
                    'error' => 'coin not found' 
                ]);
            }
            if (isset($data['coin_image'])) {
                $coin->coin_image = $this->saveImage($data);
            }
            $coin->coin_name = $data['coin_name'];
            $coin->coin_price = $data['coin_price'];
            $coin->min_withdraw = $data['min_withdraw'];
            $coin->coin_decimal = $data['coin_decimal'];
            $coin->rate_coin = $data['rate_coin'];
            $coin->coin_fee = $data['coin_fee'];
            $coin->status = $data['status'];
            $coin->network_id =json_encode($data['network_id']);
            $coin->save();
            return response()->json([
                'error_code' => 0,
                'message' => 'Update successful' // Fixed spelling
            ]);
       } catch (\Throwable $th) {
            Log::error('Error creating coin: ' . $th->getMessage());
        }
    }
    public function destroy(Request $request)
    {
        $id = $request->input('id');
        $coin = Coin_model::findOrFail($id);
        if (!$coin) {
            return response()->json([
                'error_code' => 1,
                'message' => 'coin not found'
            ]);
        }
        if ($coin->coin_image) {
            Storage::delete('public/' . $coin->coin_image);
        }
        $coin->delete();
        return response()->json([
            'error_code' => 0,
            'message' => 'Delete successful'
        ]);
    }
    public function saveImage($data)
    {
        $image = $data['coin_image'];
        $ext = $image->extension();
        $imageName = time() . '-image.' . $ext;
        $imagePath = 'uploads/' . $imageName;
        $image->storeAs('public', $imagePath);
        $imageUrl = Storage::url($imagePath);
        return $imageUrl;
    }
    
}