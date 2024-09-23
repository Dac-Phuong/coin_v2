<?php

namespace App\Livewire\Admin\Deposit;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class DetailDeposit extends Component
{
    public $detail = null;
    protected $listeners = ['update' => 'mount'];
    public function mount($id = null)
    {
        $this->detail = DB::table('investor_with_plants')
            ->join('investors', 'investor_with_plants.investor_id', '=', 'investors.id')
            ->leftJoin('plan_models', 'investor_with_plants.plan_id', '=', 'plan_models.id')
            ->where('investor_with_plants.id', $id)
            ->select('investor_with_plants.*', 'investors.fullname as investor_name', 'plan_models.name as plan_name', 'plan_models.title as plan_title', 'plan_models.discount as plan_discount')
            ->first();
    }
    public function generateQrCode()
    {
        return isset($this->detail) && $this->detail->wallet_address ? QrCode::size(200)->generate($this->detail->wallet_address) : QrCode::size(200)->generate('error');
    }

    public function render()
    {
        return view('livewire.admin.deposit.detail-deposit');
    }
}