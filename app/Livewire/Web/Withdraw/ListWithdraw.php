<?php

namespace App\Livewire\Web\Withdraw;

use App\Components\InterestCalculator;
use App\Components\UpdateBalance;
use App\Models\investor_coin;
use App\Models\Investors;
use App\Models\Withdraw;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Withdrawal_fees;
use Illuminate\Support\Facades\DB;

class ListWithdraw extends Component
{
    use WithPagination;
    #[Title('Withdraw')]

    public $ref;
    public $account_balance;
    public $updateBalance;
    public $investor;
    public $interestCalculator;
    public $loadingId;
    protected $listeners = [
        'success' => 'render',
    ];
    public function mount()
    {
        $data_investor = session()->get('investor');
        $this->investor = Investors::find($data_investor ? $data_investor->id : '');
        if (!$this->investor || $this->investor->status == "1") {
            return $this->redirect('/login', navigate: true);
        }
    }

    public function cancel($id)
    {
        $this->loadingId = $id;
        $withdraw = Withdraw::find($id);
        $investor_coin = investor_coin::where('investor_id', $this->investor->id)->where('coin_id', $withdraw->coin_id)->first();
        if ($withdraw && $withdraw->status == 0) {
            $withdraw->status = 2;
            $investor_coin->available_balance += $withdraw->amount;
            $withdraw->save();
            $investor_coin->save();
            $this->sendMesageTelegram($withdraw);
            $this->loadingId = null;
            $update = new UpdateBalance();
            $this->updateBalance = $update->updateAccountBalance($this->investor);
        }
    }
    public function sendMesageTelegram($cancel_withdraw)
    {
        $status = 'Cancel';
        $botApiToken = env('TELEGRAM_TOKEN');
        $channelId = env('TELEGRAM_CHANEL_ID');
        $txtMesage = "
            ✨================🔥🔥🔥🔥🔥===================✨
            ✨============= LỆNH HỦY RÚT TIỀN =============
            ✨=================🔥🔥🔥🔥🔥==================
            ✨Số tiền : $" . $cancel_withdraw->amount . "
            ✨Trạng Thái : " . $status . "
            ✨Tên : " . $this->investor->username . "
            ✨Email : " . $this->investor->email . "
            ✨================⚡️⚡️⚡️⚡️⚡️====================✨";
        $query = http_build_query([
            'chat_id' => $channelId,
            'text' => $txtMesage,
        ]);
        $url = "https://api.telegram.org/bot{$botApiToken}/sendMessage?{$query}";

        $curl = curl_init();
        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST => 'GET',
            )
        );
        curl_exec($curl);
        curl_close($curl);
    }
    public function render()
    {
        $ref = url()->to('/');
        if ($ref && $this->investor) {
            $this->ref = $ref . '/register?ref=' . $this->investor->referal_code;
        }
        $list_withdraw = DB::table('withdraws')
            ->leftJoin('coin_models', 'coin_models.id', '=', 'withdraws.coin_id')
            ->select('withdraws.*', 'coin_models.coin_name as coin_name', 'coin_models.coin_decimal	 as coin_decimal')
            ->where('investor_id', $this->investor->id)->orderBy('created_at', 'desc')->paginate(10);
        $calculator = new InterestCalculator();
        $this->interestCalculator = $calculator->calculator_interest($this->investor);
        $investor_coins = DB::table('investor_coins')
            ->join('coin_models', 'coin_models.id', '=', 'investor_coins.coin_id')
            ->select('investor_coins.*', 'coin_models.*')
            ->where('investor_coins.investor_id', $this->investor->id)
            ->paginate(10);
        return view('livewire.web.withdraw.list-withdraw', ['list_withdraw' => $list_withdraw, 'investor_coins' => $investor_coins])->extends('components.layouts.app')->section('content');
    }

}