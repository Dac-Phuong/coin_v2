<?php

namespace App\Livewire\Admin\Plans\PlanFixed;

use App\Models\PlanModel;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
class ListPlan extends Component
{
    use WithPagination;

    public $search = '';
    public $perpage = 20;
    public $plan;
    public $id;
    public $toggleState = false;
    protected $listeners = [
        'success' => 'update',
        'delete' => 'delete'
    ];
    public function toggle($id = null)
    {
        if ($id != $this->id) {
            $this->id = $id;
            $this->toggleState = true;
        } else {
            $this->toggleState = !$this->toggleState;
        }
    }
    public function closeToggle()
    {
        $this->toggleState = false;
    }
    public function update()
    {
        $this->plan = PlanModel::all();
        $this->reset();
    }
    public function delete($id)
    {
        $plan = PlanModel::find($id);
        if (!is_null($plan)) {
            $plan->delete();
        }
        $this->dispatch('success', 'Delete fixed plan successfully.');
    }
    public function render()
    {
        $list_plans = DB::table('plan_models')
        ->join('coin_models','plan_models.coin_id','=','coin_models.id')
        ->select('plan_models.*','coin_models.coin_name as coin_name')
        ->where('plan_models.package_type', 1)
        ->where(function ($query) {
                if ($this->search) {
                    $query->where('plan_models.name', 'like', '%' . $this->search . '%')
                        ->orWhere('plan_models.title', 'like', '%' . $this->search . '%')
                        ->orWhere('coin_models.coin_name', 'like', '%' . $this->search . '%');
                }
            })
        
        ->orderBy('created_at', 'desc')->paginate($this->perpage);
        return view('livewire.admin.plans.plan-fixed.list-plan', ['list_plans' => $list_plans]);
    }
}
