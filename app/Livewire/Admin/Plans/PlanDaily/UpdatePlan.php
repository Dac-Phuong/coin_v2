<?php

namespace App\Livewire\Admin\Plans\PlanDaily;

use App\Models\Daily_discounts;
use App\Models\PlanModel;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Str;

class UpdatePlan extends Component
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
    public $id;
    public $plan_daily;
    protected $listeners = ['update' => 'mount'];

    public function mount($id = null)
    {
        $this->inputs = [];
        $this->plan_daily = PlanModel::find($id);
        $this->discount_daily = Daily_discounts::where('plan_id', $id)
            ->selectRaw('DATE(end_date) as end_date, DATE(start_date) as start_date, discount,id')
            ->get()
            ->toArray();
        foreach ($this->discount_daily as $key => $value) {
            array_push($this->inputs, $key);
        }
        if ($this->plan_daily) {
            $this->name = $this->plan_daily->name;
            $this->title = $this->plan_daily->title;
            $this->discount = $this->plan_daily->discount;
            $this->min_deposit = $this->plan_daily->min_deposit;
            $this->max_deposit = $this->plan_daily->max_deposit;
            $this->from_date = \Carbon\Carbon::parse($this->plan_daily->from_date)->setTimezone('Asia/Ho_Chi_Minh')->toDateString();
            $this->to_date = \Carbon\Carbon::parse($this->plan_daily->to_date)->setTimezone('Asia/Ho_Chi_Minh')->toDateString();
            $this->end_date = \Carbon\Carbon::parse($this->plan_daily->end_date)->setTimezone('Asia/Ho_Chi_Minh')->toDateString();
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
        if (isset($this->discount_daily[$key])) {
            $discount_daily = Daily_discounts::find($this->discount_daily[$key]['id']);
            $discount_daily->delete();
            unset($this->discount_daily[$key]);
        }
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

        $this->plan_daily->name = $this->name;
        $this->plan_daily->title = $this->title;
        $this->plan_daily->discount = $this->discount;
        $this->plan_daily->min_deposit = $this->min_deposit;
        $this->plan_daily->max_deposit = $this->max_deposit;
        $this->plan_daily->from_date = $this->from_date;
        $this->plan_daily->to_date = Carbon::parse($this->to_date)->endOfDay();
        $this->plan_daily->end_date = Carbon::parse($this->end_date)->endOfDay();
        $this->plan_daily->save();

        foreach ($this->discount_daily as $value) {
            $discount_daily = Daily_discounts::find($value['id'] ?? 0);
            if ($discount_daily) {
                $discount_daily->discount = $value['discount'];
                $discount_daily->end_date = Carbon::parse($value['end_date'])->endOfDay();
                $discount_daily->start_date = $value['start_date'];
                $discount_daily->save();
            } else {
                $discount_daily = Daily_discounts::create([
                    'plan_id' => $this->plan_daily->id,
                    'discount' => $value['discount'],
                    'end_date' => Carbon::parse($value['end_date'])->endOfDay(),
                    'start_date' => $value['start_date'],
                ]);
                $discount_daily->save();
            }
        }
        $this->dispatch('success', 'Edit your daily plan successfully.');
        $this->reset();
    }
    public function render()
    {
        return view('livewire.admin.plans.plan-daily.update-plan');
    }
}
