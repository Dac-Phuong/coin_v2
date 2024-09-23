<?php

namespace App\Livewire\Admin\Plans\PlanDaily;

use App\Models\Daily_discounts;
use App\Models\PlanModel;
use Carbon\Carbon;
use Livewire\Component;

class CreatePlan extends Component
{
    public $name;
    public $title;
    public $discount;
    public $discount_daily = [];
    public $from_date;
    public $to_date;
    public $end_date;
    public $min_deposit;
    public $max_deposit;
    public $type_date;
    public $inputs = [];
    public $i = 1;

    public function addInput($i)
    {
        $this->i = $i;
        array_push($this->inputs, $i);
    }
    public function remove($key)
    {
        unset($this->inputs[$key]);
        unset($this->discount_daily[$key]);
    }
    public function submit()
    {
        $this->validate([
            'name' => 'required|string',
            'title' => 'required|string',
            'discount' => 'required|numeric',
            'min_deposit' => 'required|numeric',
            'max_deposit' => 'required|numeric|gt:min_deposit',
            'from_date' => 'required|date',
            'to_date' => 'required|date|after:from_date',
            'end_date' => 'required|date|after:from_date|before:to_date',
            'discount_daily.*.start_date' => 'required|date|after_or_equal:from_date|before_or_equal:to_date',
            'discount_daily.*.end_date' => 'required|date|after_or_equal:from_date|before_or_equal:to_date',
            'discount_daily.*.discount' => 'required|numeric',
        ], [
            'discount_daily.*.start_date.after_or_equal' => 'The profit start date must be after or equal to the plan start date.',
            'discount_daily.*.start_date.before_or_equal' => 'The profit start date must be before or equal to the plan end date.',
            'discount_daily.*.end_date.after_or_equal' => 'The profit end date must be after or equal to the plan start date.',
            'discount_daily.*.end_date.before_or_equal' => 'The profit end date must be before or equal to the plan end date.',
        ]);


        $plan = PlanModel::create([
            'name' => $this->name,
            'title' => $this->title,
            'discount' => $this->discount,
            'min_deposit' => $this->min_deposit,
            'max_deposit' => $this->max_deposit,
            'from_date' => $this->from_date,
            'to_date' => Carbon::parse($this->to_date)->endOfDay(),
            'end_date' => Carbon::parse($this->end_date)->endOfDay(),
            'package_type' => 0,
        ]);
        $plan->save();

        foreach ($this->discount_daily as  $value) {
            $daily_discount = Daily_discounts::create([
                'plan_id' => $plan->id,
                'discount' => $value['discount'],
                'start_date' => $value['start_date'],
                'end_date' => Carbon::parse($value['end_date'])->endOfDay()
            ]);
            $daily_discount->save();
        }
        $this->dispatch('success', 'Add daily planning successfully.');
        $this->reset();
    }
    public function render()
    {
        return view('livewire.admin.plans.plan-daily.create-plan');
    }
}
