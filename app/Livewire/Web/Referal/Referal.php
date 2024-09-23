<?php

namespace App\Livewire\Web\Referal;

use App\Components\InterestCalculator;
use App\Models\Investors;
use App\Models\Referal_detail;
use App\Models\Referals;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Title;
use Livewire\Component;

class Referal extends Component
{
    #[Title('Referrals')]
    public $ref;
    public $interestCalculator;
    public $referal;
    public $perpage = 10;
    public $number_referals = 0;
    public $ref_detail = null;
    public $investor;
    public function mount()
    {
        $data_investor = session()->get('investor');
        $this->investor = Investors::find($data_investor ? $data_investor->id : '');
        if (!$this->investor || $this->investor->status == "1") {
            return $this->redirect('/login', navigate: true);
        }
    }
    public function render()
    {
        $this->referal = Referals::first();
        $this->number_referals = Referal_detail::where('parent_code', $this->investor->referal_code)->sum('number_referals');
        $this->ref_detail = DB::table('referal_details')
            ->join('coin_models', 'referal_details.coin_id', '=', 'coin_models.id')
            ->select('referal_details.*', 'coin_models.coin_name as coin_name')
            ->where('referal_details.status', 1)
            ->where('parent_code', $this->investor->referal_code)
            ->first();
        $ref = url()->to('/');
        if ($ref && $this->investor) {
            $this->ref = $ref . '/register?ref=' . $this->investor->referal_code;
        }
        $array_id = Referal_detail::where('parent_code', $this->investor->referal_code)->pluck('investor_id');
        $list_referal = Investors::whereIn('id', $array_id)->orderBy('created_at', 'desc')->paginate($this->perpage);
        $calculator = new InterestCalculator();
        $this->interestCalculator = $calculator->calculator_interest($this->investor);
        return view('livewire.web.referal.referal', ['list_referal' => $list_referal])->extends('components.layouts.app')->section('content');
    }
}
