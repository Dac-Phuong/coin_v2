<?php

namespace App\Livewire\Web\Account;

use App\Models\Coin_model;
use App\Models\Investor_with_plants;
use App\Models\Investors;
use App\Models\Network;
use App\Models\Wallets;
use Livewire\Component;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ModalDeposit extends Component
{
    public $coins;
    public $coin;
    public $coin_id;
    public $networks;
    public $network_id;
    public $coin_name;
    public $network_fee = null;
    public $coin_price = 0;
    public $amount;
    public $investor;
    public $wallet;
    public $wallet_address;
    public function mount()
    {
        $data_investor = session()->get("investor");
        // lấy ra investor
        $this->investor = Investors::find($data_investor ? $data_investor->id : '');
        if (!$this->investor || $this->investor->status == "1") {
            return $this->redirect('/login', navigate: true);
        }
    }

    public function checkbox($id = null)
    {
        $this->coin_id = $id;
        $this->coin = Coin_model::find($id);
        if ($this->coin) {
            $this->network_id = null;
            $this->coin_price = $this->coin->coin_price;
            $this->coin_name = $this->coin->coin_name;
        }
    }
    public function submit()
    {
        $this->validate([
            "network_id" => "required",
            'amount' => [
                'required',
                'numeric',
                'gt:0',
                'regex:/^\d+(\.\d+)?$/',
                'not_regex:/\.$/'
            ],
        ], [
            'network_id.required' => 'The network field is required.'
        ]);
        $deposit = Investor_with_plants::create([
            'investor_id' => $this->investor->id,
            'coin_id' => $this->coin_id,
            'plan_id' => 0,
            'name_coin' => $this->coin_name,
            'network_name' => '',
            'profit' => 0,
            'number_days' => 0,
            'amount' => $this->amount,
            'total_amount' => $this->amount,
            'type_payment' => 3,
            'total_last_seconds' => 0,
            'wallet_id' => 0,
            'network_fee' => 0,
            'wallet_address' => $this->wallet_address,
            'current_coin_price' => $this->coin_price,
            'total_coin_price' => 0,
            'status' => 0,
        ]);
        $deposit->save();
        $this->dispatch('success', 'Deposit success.');
        $this->sendMesageTelegram($deposit);
        $this->reset();
        return $this->redirect('/list-deposit', navigate: true);

    }
    public function generateQrCodeBSC()
    {
        return $this->wallet && $this->wallet_address ? QrCode::size(220)->generate($this->wallet_address) : QrCode::size(220)->generate('null');
    }
    public function getWallet($network)
    {
        if (isset($network->id)) {
            $wallet = Wallets::where('network_id', $network->id)
                ->where('status', 0)
                ->inRandomOrder() 
                ->first();

            $this->wallet = $wallet;
            return $wallet ? $wallet->wallet_address : null;
        }
        return null;
    }
    public function sendMesageTelegram($deposit)
    {
        $status = '';
        switch ($deposit['status']) {
            case 0:
                $status = 'Pending';
                break;
            case 1:
                $status = 'Running';
                break;
            default:
                break;
        }

        $botApiToken = env('TELEGRAM_TOKEN');
        $channelId = env('TELEGRAM_CHANEL_ID');
        $txtMesage = "
            ✨================🌟🌟🌟🌟🌟===================✨
            ✨============= LỆNH NẠP TIỀN =============
            ✨=================🌟🌟🌟🌟🌟==================
            ✨Coin : " . $deposit['name_coin'] . "
            ✨Gói : " . $deposit['amount'] . "
            ✨Trạng Thái : " . $status . "
            ✨Tên : " . $this->investor->username . "
            ✨Email : " . $this->investor->email . "
            ✨Địa chỉ ví chuyển : " . $this->wallet_address . "
            ✨==================🌟🌟🌟🌟🌟==================✨";
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
        $this->coins = Coin_model::where('status', 0)->orderBy('created_at', 'asc')->get();
        $this->networks = Network::where('status', 0)->orderBy('created_at', 'asc')->get();
        if (isset($this->network_id) || isset($this->coin_id)) {
            $coin = Coin_model::find($this->coin_id);
            $network = Network::find($this->network_id);
            $this->wallet_address = $this->getWallet($network);
            if (isset($coin)) {
                $array_id = array_filter(explode(',', str_replace(['[', ']', '"'], '', $coin->network_id)));
                $this->networks = Network::whereIn('id', $array_id)->where('status', 0)->orderBy('created_at', 'asc')->get();
                $this->coin_name = $coin->coin_name;
                $this->coin_price = $coin->coin_price;
            }
        } else {
            $this->coin = Coin_model::where('status', 0)->first();
            if (isset($this->coin)) {
                $array_id = array_filter(explode(',', str_replace(['[', ']', '"'], '', $this->coin->network_id)));
                $this->networks = Network::whereIn('id', $array_id)->where('status', 0)->orderBy('created_at', 'asc')->get();
                $this->coin_id = $this->coin->id;
            }
        }
        return view('livewire.web.account.modal-deposit');
    }
}
