<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Investor_with_plants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class DepositController extends Controller
{
    public $model;
    function __construct()
    {
        $this->model = new Investor_with_plants();
    }
    public function index()
    {
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
        $search = $data['search']['value'] ?? ''; // Uncommented search functionality
        if (!empty($search)) { // Changed isset to !empty for better check
            $query = $query->where(function ($q) use ($search) {
                $q->where('investor_name', 'like', '%' . $search . '%')
                    ->orWhere('plan_name', 'like', '%' . $search . '%')
                    ->orWhere('plan_title', 'like', '%' . $search . '%');
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
                'can_update' => Gate::allows('confirm-deposit'),
                'can_delete' => Gate::allows('cancel-deposit'),
            ],
        ];
    }
}
