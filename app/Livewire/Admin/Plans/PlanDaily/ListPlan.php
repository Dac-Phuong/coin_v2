<?php

namespace App\Livewire\Admin\Plans\PlanDaily;

use App\Models\PlanModel;
use Livewire\Component;
use Livewire\WithPagination;

class ListPlan extends Component
{
    use WithPagination;

    public $search = '';
    public $perpage = 20;
    public $plan;
    protected $listeners = [
        'success' => 'render',
        'delete' => 'delete'
    ];
    public function delete($id)
    {
        $plan = PlanModel::find($id);
        if (!is_null($plan)) {
            $plan->delete();
        }
        $this->dispatch('success', 'Delete daily plan successfully.');
    }
    public function render()
    {
        return view('livewire.admin.plans.plan-daily.list-plan', ['list_plans' => PlanModel::search($this->search)->where('package_type', 0)->orderBy('created_at', 'desc')->paginate($this->perpage)]);
    }
}
