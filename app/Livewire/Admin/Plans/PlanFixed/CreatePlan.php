<?php

namespace App\Livewire\Admin\Plans\PlanFixed;

use App\Models\Coin_model;
use App\Models\plan_number_days;
use App\Models\PlanModel;
use Illuminate\Support\Str;
use Livewire\Component;

class CreatePlan extends Component
{
    public $name;
    public $title;
    public $coins;
    public $coin_id;
    public $discount;
    public $type_date;
    public $number_date;
    public $min_deposit;
    public $max_deposit;
    public $termination_fee;
    public $number_days = [];
    public $i = 1;
    public $inputs = [];
    public function addInput($i)
    {
        $this->i = $i;
        array_push($this->inputs, $i);
    }
    public function remove($key)
    {
        unset($this->inputs[$key]);
        unset($this->number_days[$key]);
    }
    public function submit()
    {
        $this->validate(
            [
                'name' => 'required|string|unique:plan_models,name',
                'title' => 'required|string',
                'discount' => 'required|numeric',
                'coin_id' => 'required',
                'min_deposit' => 'required|numeric',
                'termination_fee' => 'required|numeric',
                'number_days.*.profit' => 'required|numeric',
            ],
            [
                'number_days.*.profit.numeric' => 'The profit field must be a number',
            ]
        );

        $plan_fixed = PlanModel::create([
            'name' => $this->name,
            'title' => $this->title,
            'discount' => $this->discount,
            'min_deposit' => $this->min_deposit,
            'package_type' => 1,
            'coin_id' => $this->coin_id,
            'type_date' => $this->type_date ?? 0,
            'termination_fee' => $this->termination_fee ?? 0,
        ]);
        $plan_fixed->save();
        if ($plan_fixed) {
            foreach ($this->number_days as $key => $value) {
                $number_days = plan_number_days::create([
                    'plan_id' => $plan_fixed->id,
                    'coin_id' => $this->coin_id,
                    'number_days' => $value["days"],
                    'profit' => $value["profit"],
                ]);
                $number_days->save();
            }
        }
        $this->dispatch('success', 'Add fixed plan successfully.');
        $this->reset();
    }
    public function render()
    {
        $this->coins = Coin_model::where('status', 0)->get();
        return view('livewire.admin.plans.plan-fixed.create-plan');
    }
}
