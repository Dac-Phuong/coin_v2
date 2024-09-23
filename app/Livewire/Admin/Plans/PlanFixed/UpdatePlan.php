<?php

namespace App\Livewire\Admin\Plans\PlanFixed;

use App\Models\Coin_model;
use App\Models\plan_number_days;
use App\Models\PlanModel;
use Livewire\Component;
use Illuminate\Support\Str;

class UpdatePlan extends Component
{
    public $plan_fixed;
    public $name;
    public $coins;
    public $coin_id;
    public $title;
    public $type_date;
    public $discount;
    public $number_date;
    public $min_deposit;
    public $max_deposit;
    public $termination_fee;
    public $inputs = [];
    public $number_days = [];
    public $i = 1;
    protected $listeners = ['update' => 'mount'];
    public function mount($id = null)
    {
        $this->inputs = [];
        $this->plan_fixed = PlanModel::find($id);
        if ($this->plan_fixed) {
            $this->number_days = plan_number_days::where('plan_id', $this->plan_fixed->id)->get()->toArray();
            foreach ($this->number_days as $key => $value) {
                array_push($this->inputs, $key);
            }
            $this->name = $this->plan_fixed->name;
            $this->title = $this->plan_fixed->title;
            $this->coin_id = $this->plan_fixed->coin_id;
            $this->number_date = $this->plan_fixed->number_date;
            $this->discount = $this->plan_fixed->discount;
            $this->min_deposit = $this->plan_fixed->min_deposit;
            $this->max_deposit = $this->plan_fixed->max_deposit;
            $this->termination_fee = $this->plan_fixed->termination_fee;
        }
    }
    public function addInput($i)
    {
        $this->i = $i;
        array_push($this->inputs, $i);
    }
    public function remove($key)
    {
        unset($this->inputs[$key]);
        if (isset($this->number_days[$key])) {
            $number_days = plan_number_days::find($this->number_days[$key]['id']);
            $number_days->delete();
            unset($this->number_days[$key]);
        }
    }
    public function submit()
    {
        $this->validate(
            [
                'name' => 'required|string',
                'title' => 'required|string',
                'number_date' => 'required',
                'discount' => 'required|numeric',
                'coin_id' => 'required|numeric',
                'min_deposit' => 'required|numeric',
                'max_deposit' => 'required|numeric',
                'termination_fee' => 'required|numeric',
                'number_days.*.profit' => 'required|numeric',
            ],
            [
                'number_days.*.profit.numeric' => 'The profit field must be a number',
            ]
        );
        $this->plan_fixed->name = $this->name;
        $this->plan_fixed->title = $this->title;
        $this->plan_fixed->discount = $this->discount;
        $this->plan_fixed->number_date = $this->number_date;
        $this->plan_fixed->min_deposit = $this->min_deposit;
        $this->plan_fixed->coin_id = $this->coin_id;
        $this->plan_fixed->max_deposit = $this->max_deposit;
        $this->plan_fixed->termination_fee = $this->termination_fee;
        $this->plan_fixed->save();
        foreach ($this->number_days as $value) {
            $number_days = plan_number_days::find($value['id'] ?? 0);
            if ($number_days) {
                $number_days->profit = $value['profit'];
                $number_days->coin_id = $this->coin_id;
                $number_days->number_days = $value['number_days'];
                $number_days->save();
            } else {
                $number_days = plan_number_days::create([
                    'plan_id' => $this->plan_fixed->id,
                    'coin_id' => $this->coin_id,
                    'profit' => $value['profit'],
                    'number_days' => $value['number_days'],
                ]);
                $number_days->save();
            }
        }
        $this->dispatch('success', 'Fixed plan update successful.');
        $this->reset();
    }
    public function render()
    {
        $this->coins = Coin_model::where('status', 0)->get();

        return view('livewire.admin.plans.plan-fixed.update-plan');
    }
}