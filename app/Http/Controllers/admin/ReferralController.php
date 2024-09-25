<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Referal_detail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReferralController extends Controller
{
    public $model;
    function __construct()
    {
        $this->model = new Referal_detail();
    }
    public function index()
    {
        return view("admin.referrals.index");
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

        if ($orderByColumn === 'created_at') {
            $orderByColumn = 'referal_details.created_at'; 
        }
        $query = $this->model->query();
        $query->select('referal_details.investor_id', 'investors.fullname', 'investors.email',
         DB::raw('SUM(referal_details.number_referals) as total_referals'), DB::raw('SUM(referal_details.amount_received) as total_amount_received'), 'referal_details.created_at') // Added created_at to select
        ->join('investors', 'referal_details.investor_id', '=', 'investors.id')
        ->groupBy('referal_details.investor_id', 'investors.fullname', 'investors.email', 'referal_details.created_at');
        // Search
        $search = $data['search']['value'] ?? '';
        if (!empty($search)) { // Changed from isset to !empty for better check
            $query = $query->where(function ($q) use ($search) {
                $q->where('investors.fullname', 'like', '%' . $search . '%') // Updated to search in fullname
                    ->orWhere('investors.email', 'like', '%' . $search . '%'); // Updated to search in email
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
           
        ];
    }
}
