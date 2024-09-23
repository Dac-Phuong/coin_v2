<?php

namespace App\Livewire\Admin\Withdraw;

use App\Models\Withdraw;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class DetailWithdraw extends Component
{
    public $detail = null;
    protected $listeners = ['update' => 'mount'];
    public function mount($id = null)
    {
        if ($id) {
            $this->detail = DB::table('withdraws')
                ->join('investors', 'withdraws.investor_id', '=', 'investors.id')
                ->select('withdraws.*', 'investors.fullname as fullname')
                ->where('withdraws.id', $id)
                ->first();
        }
    }
    public function generateQrCode()
    {
        return $this->detail ? QrCode::size(200)->generate($this->detail->wallet_address) : QrCode::size(200)->generate('error');
    }
    public function render()
    {
        return view('livewire.admin.withdraw.detail-withdraw');
    }
}