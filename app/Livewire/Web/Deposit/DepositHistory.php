<?php

namespace App\Livewire\Web\Deposit;

use App\Models\Investors;
use App\Models\Wallets;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class DepositHistory extends Component
{
    public $plan;
    public $investor;
    public $coin;
    public $deposit;
    public $wallet;

    protected $listeners = ['update' => 'mount'];
    public function mount($id = null)
    {
        $data_investor = session()->get('investor');
        if (!$data_investor) {
            return $this->redirect('/login', navigate: true);
        }
        if ($id) {
            $this->investor = Investors::find($data_investor->id);
            $this->deposit = DB::table('investor_with_plants')
                ->leftJoin('plan_models', 'investor_with_plants.plan_id', '=', 'plan_models.id')
                ->join('coin_models', 'investor_with_plants.coin_id', '=', 'coin_models.id')
                ->select('investor_with_plants.*', 'plan_models.name as plan_name', 'coin_models.coin_fee as coin_fee', 'coin_models.coin_decimal as coin_decimal')
                ->where('investor_with_plants.id', $id)
                ->first();
            if (isset($this->deposit->wallet_id)) {
                $this->wallet = Wallets::find($this->deposit->wallet_id);
                if ($this->wallet) {
                    $this->generateQrCodeBSC();
                }
            }
        }

    }
    public function generateQrCodeBSC()
    {
        return $this->wallet ? QrCode::size(220)->generate($this->wallet->wallet_address) : QrCode::size(220)->generate('null');
    }
    public function render()
    {
        return view('livewire.web.deposit.deposit-history');
    }
}