<?php

namespace App\Livewire\Admin\Investors;

use App\Models\Investor_with_plants;
use Illuminate\Support\Facades\DB;
use App\Models\Investors;
use App\Models\Withdraw;
use Livewire\Component;

class DetailInvestor extends Component
{
    public $investor;
    public $total_deposit;
    public $total_widthdraw;
    public $list_wallets;
    protected $listeners = ['update' => 'mount'];
    public function mount($id = null)
    {
        $this->investor = Investors::find($id);
         $this->list_wallets = null;
        if($this->investor){
            $this->total_deposit = Investor_with_plants::where('investor_id', $this->investor->id)->where('status', '!=', '3')->sum('amount');
            $this->total_widthdraw = Withdraw::where('investor_id', $this->investor->id)->where('status', 1)->sum('amount');
             $this->list_wallets = DB::table('investor_wallets')
            ->join('networks', 'networks.id', '=', 'investor_wallets.network_id')
            ->select('investor_wallets.*', 'networks.network_name as network_name')
            ->where('investor_id', $this->investor->id)
            ->get();
        }
    }
    public function render()
    {
        return view('livewire.admin.investors.detail-investor');
    }
}
