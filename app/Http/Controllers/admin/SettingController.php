<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Livewire\Web\Referal\Referal;
use App\Models\Referals;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    public function index()
    {
        return view("admin.settings.index");
    }
    public function get()
    {
        try {
            $referral_fees = Referals::first();
            return response()->json([
                'error_code' => 0,
                'data' => $referral_fees
            ]);
        } catch (\Exception $e) {
            Log::error('Error creating coin: ' . $e->getMessage());
        }
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "commissions" => "required|numeric",
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error_code' => 1,
                'error' => $validator->errors()->first()
            ]);
        }
        $data = $request->all();
        $referral = Referals::find($data['id'] ?? 0);
        try {
            if (!$referral) {
                Referals::create([
                    'amount_money' => $data['commissions'],
                ]);
                return response()->json([
                    'error_code' => 0,
                    'message' => 'Create successfully'
                ]);
            }
            $referral->amount_money = $data['commissions'];
            $referral->save();
            return response()->json([
                'error_code' => 0,
                'message' => 'Update successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Error creating coin: ' . $e->getMessage());
        }
    }
    public function destroy(Request $request)
    {
        $id = $request->id;
        $referral = Referals::find($id);
        if (!$referral) {
            return response()->json([
                'error_code' => 1,
                'message' => 'referral not found'
            ]);
        }
        $referral->delete();
        return response()->json([
            'error_code' => 0,
            'message' => 'Delete successfully'
        ]);
    }
}
