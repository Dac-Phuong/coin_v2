<?php

namespace App\Livewire\Admin\Referral;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ListReferral extends Component
{
    public $perpage = 20;
    public $search = '';
    public function render()
    {
        $list_referral = DB::table('referal_details')
            ->select('referal_details.investor_id', 'investors.fullname', 'investors.email', DB::raw('SUM(referal_details.number_referals) as total_referals'), DB::raw('SUM(referal_details.amount_received) as total_amount_received'))
            ->join('investors', 'referal_details.investor_id', '=', 'investors.id')
            ->groupBy('referal_details.investor_id', 'investors.fullname', 'investors.email')
            ->where(function ($query) {
                if ($this->search) {
                    $query->where('investors.fullname', 'like', '%' . $this->search . '%')
                        ->orWhere('investors.email', 'like', '%' . $this->search . '%');
                }
            })
            ->paginate($this->perpage);
        return view('livewire.admin.referral.list-referral', ['list_referral' => $list_referral]);
    }
}
