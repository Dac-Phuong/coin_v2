<?php

namespace App\Livewire\Admin\Investors;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class HistoryDeposit extends Component
{
    public $id;
    public $perpage = 20;
    public $search = '';

    public function mount($id)
    {
        $this->id = $id;
    }
    public function render()
    {
        $history_deposit = DB::table('investor_with_plants')
            ->join('investors', 'investor_with_plants.investor_id', '=', 'investors.id')
            ->join('plan_models', 'investor_with_plants.plan_id', '=', 'plan_models.id')
            ->select('plan_models.*', 'investor_with_plants.id as Investor_with_plants_id', 'investor_with_plants.number_days as number_days', 'investor_with_plants.name_coin as name_coin', 'investor_with_plants.status as investor_with_plants_status', 'investor_with_plants.amount as amount', 'investor_with_plants.total_amount as total_amount', 'investor_with_plants.created_at as start_date', 'investors.fullname as investor_name', 'plan_models.name as plan_name', 'plan_models.title as plan_title', 'investor_with_plants.profit as plan_discount')
            ->where(function ($query) {
                if ($this->search) {
                    $query->where('plan_models.discount', 'like', '%' . $this->search . '%')
                        ->orWhere('plan_models.min_deposit', 'like', '%' . $this->search . '%')
                        ->orWhere('plan_models.name', 'like', '%' . $this->search . '%');
                }
            })
            ->where('investor_id', $this->id)
            ->orderBy('start_date', 'desc')
            ->paginate($this->perpage);
        return view('livewire.admin.investors.history-deposit', ['history_deposit' => $history_deposit]);
    }
}
