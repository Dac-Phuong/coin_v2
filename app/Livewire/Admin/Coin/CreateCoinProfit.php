<?php

namespace App\Livewire\Admin\Coin;

use App\Models\Coin_plan;
use App\Models\plan_number_days;
use App\Models\PlanModel;
use Livewire\Component;

class CreateCoinProfit extends Component
{
    public $number_days = [];
    public $plans;
    public $plan_id;
    public $coin_id;
    public $coin_plan;
    public $i = 1;
    public $isCheck = false;
    public $inputs = [];
    protected $listeners = ['update' => 'mount', 'success' => 'render',];
    public function mount($id = null)
    {
        $this->coin_id = $id;
    }

    public function addInput($i)
    {
        $this->isCheck = true;
        $this->i = $i;
        array_push($this->inputs, $i);

    }
    public function remove($key)
    {
        unset($this->inputs[$key]);
        $this->isCheck = false;
        if (isset($this->number_days[$key])) {
            $number_days = plan_number_days::find($this->number_days[$key]['id']);
            $number_days->delete();
            unset($this->number_days[$key]);
        }
    }
    public function submit()
    {
        $this->validate([
            'plan_id' => 'required',
        ], [
            'plan_id.required' => 'The plan field is required.',
        ]);
        if ($this->number_days && $this->coin_plan) {
            foreach ($this->number_days as $value) {
                $number_days = Coin_plan::find($value['id'] ?? 0);
                if ($number_days) {
                    $number_days->profit = $value['profit'];
                    $number_days->number_days = $value['number_days'];
                    $number_days->save();
                } else {
                    $number_days = Coin_plan::create([
                        'coin_id' => $this->coin_id,
                        'plan_id' => $this->plan_id,
                        'profit' => $value["profit"],
                        'number_days' => $value["number_days"],
                    ]);
                    $number_days->save();
                }
            }
            $this->dispatch('success', 'Update profit successfully.');
        } else {
            foreach ($this->number_days as $key => $value) {
                $query = Coin_plan::create([
                    'coin_id' => $this->coin_id,
                    'plan_id' => $this->plan_id,
                    'profit' => $value["profit"],
                    'number_days' => $value["number_days"],
                ]);
                $query->save();
            }
            $this->dispatch('success', 'Add profit successfully.');
        }
    }
    public function updatedPlanId($value)
    {
        if ($value) {
            $this->inputs = [];
            $this->validate([
                'plan_id' => 'required',
            ]);

            $this->coin_plan = Coin_plan::where('plan_id', $this->plan_id)
                ->where('coin_id', $this->coin_id)
                ->get()
                ->toArray();

            if ($this->coin_plan) {
                $this->number_days = $this->coin_plan;
                foreach ($this->coin_plan as $key => $value) {
                    $this->inputs[] = $key;
                }
            } else {
                $this->number_days = plan_number_days::where('plan_id', $this->plan_id)
                    ->get()
                    ->toArray();
                foreach ($this->number_days as $key => $value) {
                    $this->inputs[] = $key;
                }
            }
        } else {
            $this->inputs = [];
        }
    }
    public function render()
    {
        $this->plans = PlanModel::where('package_type', 1)->where('status', 0)->get();
        return view('livewire.admin.coin.create-coin-profit');
    }
}