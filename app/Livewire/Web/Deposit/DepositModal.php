<?php

namespace App\Livewire\Web\Deposit;

use App\Components\InterestCalculator;
use App\Models\Coin_model;
use App\Models\Daily_discounts;
use App\Models\investor_coin;
use App\Models\Investor_with_plants;
use App\Models\Investors;
use App\Models\Network;
use App\Models\plan_number_days;
use App\Models\PlanModel;
use App\Models\Wallets;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class DepositModal extends Component
{
    public $plan;
    public $min_deposit;
    public $investor;
    public $daily_discounts;
    public $interestCalculator;
    public $wallets;
    public $wallet;
    public $wallet_address;
    public $wallet_name;
    public $network_name;
    public $coin_decimal;
    public $amount = 0;
    public $total = 0;
    public $type_payment = 0;
    public $profit = 0;
    public $number_days_id;
    public $plan_number_days;
    public $current_discount;
    public $currentTab = 'tab1';
    public $isOpen = true;
    public $total_amount;
    public $number_days;
    public $curent_date;
    public $query_plan_number_days;
    public $coins;
    public $coin;
    public $coin_price;
    public $coin_name;
    public $total_coin_price;
    public $network = [];
    public $network_id;
    public $networkId;
    public $coin_id;
    protected $listeners = ['update' => 'mount'];
    public function mount($id = null, $coin_id = null)
    {
        $data_investor = session()->get('investor');
        if (!$data_investor) {
            return $this->redirect('/login', navigate: true);
        }
        $this->investor = Investors::find($data_investor->id);
        $this->plan = PlanModel::find($id);
        $this->curent_date = Carbon::now();
        $this->isOpen = true;
        if ($this->plan) {
            // dd($this->plan);
            $this->coin_id = $coin_id;
            $this->coin = Coin_model::find($coin_id);
            if ($this->coin) {
                $this->coin_id = $this->coin->id;
                $this->coin_price = $this->coin->coin_price;
                $this->coin_name = $this->coin->coin_name;
                $this->coin_decimal = $this->coin->coin_decimal;
                $array_id = array_filter(explode(',', str_replace(['[', ']', '"'], '', $this->coin->network_id)));
                $this->network_id = Network::whereIn('id', $array_id)->where('status', 0)->orderBy('created_at', 'asc')->first()->id;
                $this->network = Network::whereIn('id', $array_id)->where('status', 0)->orderBy('created_at', 'asc')->get();
                if ($this->network) {
                    foreach ($this->network as $key => $value) {
                        $this->wallets = Wallets::where('network_id', $value->id)->where('status', 0)->get();
                    }
                }
            }
            $this->min_deposit = $this->plan->min_deposit;
            $this->coins = Coin_model::first();
            $this->query_plan_number_days = plan_number_days::where('plan_id', $this->plan->id)->where('coin_id', $this->coins->id)->first();
            if (isset($this->query_plan_number_days)) {
                $this->number_days_id = $this->query_plan_number_days->id;
            }
            $this->daily_discounts = Daily_discounts::where('plan_id', $this->plan->id)
                ->orderBy('start_date')
                ->get()
                ->toArray();
            $this->calculateCurrentDiscount($this->curent_date);
        }
    }
    public function calculateCurrentDiscount($curent_date)
    {
        $this->current_discount = $this->plan->discount;
        $from_date = Carbon::parse($this->plan->from_date);
        $to_date = Carbon::parse($this->plan->to_date);
        $end_date = Carbon::parse($this->plan->end_date);
        if ($curent_date->greaterThanOrEqualTo($from_date) && $curent_date->lessThanOrEqualTo($to_date)) {
            foreach ($this->daily_discounts as $value) {
                $start_date = Carbon::parse($value['start_date']);
                $end_date = Carbon::parse($value['end_date']);
                if ($curent_date->greaterThanOrEqualTo($start_date) && $curent_date->lessThanOrEqualTo($end_date)) {
                    $this->current_discount = $value['discount'];
                    break;
                } else {
                    $this->current_discount = $this->plan->discount;
                }
            }
        } elseif ($curent_date > $end_date) {
            $this->isOpen = false;
        }
    }
    public function switchTab($tab)
    {
        $this->currentTab = $tab;
        if ($this->currentTab == 'tab2') {
            $this->type_payment = 1;
        } else {
            $this->type_payment = 0;
        }
    }
    public function generateQrCodeBSC()
    {
        return $this->wallets && $this->wallet_address ? QrCode::size(220)->generate($this->wallet_address) : QrCode::size(220)->generate('null');
    }
    public function sendMesageTelegram($invertPlant)
    {
        $status = '';
        switch ($invertPlant['status']) {
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
            ✨============= LỆNH ĐẦU TƯ =============
            ✨=================🌟🌟🌟🌟🌟==================
            ✨Coin : " . $invertPlant['name_coin'] . "
            ✨Gói : $" . $invertPlant['amount'] . "
            ✨Trạng Thái : " . $status . "
            ✨Tên : " . $this->investor->username . "
            ✨Email : " . $this->investor->email . "
            ✨Địa chỉ ví chuyển : " . $this->investor->wallet_address . "
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
    public function submit()
    {
        if ($this->type_payment == 1) {
            $query = investor_coin::where('investor_id', $this->investor->id)->where('coin_id', $this->coin_id)->first();
            if (!$query || $query->available_balance < $this->plan->min_deposit) {
                session()->flash('error', 'Your account balance is not enough to purchase the package.');
            } else {
                if ($this->plan->package_type == 1 && $this->query_plan_number_days) {
                    $invertPlant = array(
                        'investor_id' => $this->investor->id,
                        'coin_id' => $this->coin_id,
                        'plan_id' => $this->plan->id,
                        'name_coin' => $this->coin_name,
                        'network_name' => $this->network_name,
                        'profit' => $this->query_plan_number_days->profit,
                        'number_days' => $this->query_plan_number_days->number_days,
                        'amount' => $this->plan->min_deposit,
                        'total_amount' => (($this->query_plan_number_days->profit / 100) * $this->plan->min_deposit) + $this->plan->min_deposit,
                        'type_payment' => $this->type_payment,
                        'total_last_seconds' => 0,
                        'wallet_id' => 0,
                        'wallet_address' => '',
                        'current_coin_price' => $this->coin_price,
                        'total_coin_price' => 0,
                        'status' => 1,
                    );
                    $deposit = Investor_with_plants::create($invertPlant);
                    $query->available_balance -= $this->plan->min_deposit;
                    $query->amount -= $this->plan->min_deposit;
                    $query->save();
                    $this->sendMesageTelegram($invertPlant);
                    $deposit->save();
                    $this->updateAccountBalance($this->investor);
                }
                $this->dispatch('success', 'T');
                return $this->redirect('/list-deposit', navigate: true);
            }
        } else {
            if ($this->plan->package_type == 1 && $this->query_plan_number_days) {
                $invertPlant = [
                    'investor_id' => $this->investor->id,
                    'coin_id' => $this->coin_id,
                    'plan_id' => $this->plan->id,
                    'name_coin' => $this->coin_name,
                    'network_name' => $this->network_name,
                    'network_fee' => 0,
                    'profit' => $this->query_plan_number_days->profit,
                    'number_days' => $this->query_plan_number_days->number_days,
                    'amount' => $this->plan->min_deposit,
                    'total_amount' => (($this->query_plan_number_days->profit / 100) * $this->plan->min_deposit) + $this->plan->min_deposit,
                    'type_payment' => $this->type_payment,
                    'total_last_seconds' => 0,
                    'wallet_id' => $this->wallet->id,
                    'wallet_address' => $this->wallet_address,
                    'current_coin_price' => $this->coin_price,
                    'total_coin_price' => $this->total_coin_price,
                    'status' => 0,
                ];
                $deposit = Investor_with_plants::create($invertPlant);
                $investor_coin = investor_coin::where('investor_id', $this->investor->id)->where('coin_id', $this->coin_id)->first();
                if (!$investor_coin) {
                    $investor_coin = investor_coin::create([
                        'coin_id' => $this->coin_id,
                        'investor_id' => $this->investor->id,
                        'available_balance' => 0,
                        'amount' => 0,
                        'status' => 0,
                    ]);
                    $investor_coin->save();
                }
                $this->sendMesageTelegram($invertPlant);
                $this->wallet->status = 1;
                $this->wallet->save();
                $deposit->save();
            }
            $this->dispatch('success', 'T');
            return $this->redirect('/list-deposit', navigate: true);
        }
    }
     public function updateAccountBalance($investor)
    {
            $total_balance = DB::table('investor_coins')
                ->join('coin_models', 'investor_coins.coin_id', '=', 'coin_models.id')
                ->where('investor_coins.investor_id', $investor->id)
                ->sum(DB::raw('investor_coins.available_balance * coin_models.coin_price'));
            $investor->balance = $total_balance;
            $investor->save();
    }
    public function getWallet($network)
    {
        if (isset($this->plan) && $this->plan->id) {
            $wallet = Wallets::where('plan_id', $this->plan->id)
                ->where('network_id', $network->id)
                ->where('status', 0)
                ->first();
            $this->wallet = $wallet;
            return $wallet ? $wallet->wallet_address : null;
        }
        return null;
    }
    public function render()
    {
        if (isset($this->networkId) || isset($this->network_id) || isset($this->coin_id)) {
            $network = Network::find($this->networkId ?? $this->network_id);
            $this->wallet_address = $this->getWallet($network);
            $this->network_name = $network->network_name;
            $this->coin_decimal = $this->coin->coin_decimal;
            if ($this->plan) {
            $this->plan_number_days = plan_number_days::where('plan_id', $this->plan->id)->where('coin_id', $this->coin_id)->get();
                $this->total_coin_price = $this->plan->min_deposit  ;
                $this->query_plan_number_days = plan_number_days::where('plan_id', $this->plan->id)->where('coin_id', $this->coin_id)->first();
                if ($this->plan_number_days && $this->query_plan_number_days) {
                    $this->profit = $this->query_plan_number_days->profit;
                    $this->number_days = $this->query_plan_number_days->number_days;
                    $this->total_amount = ((($this->query_plan_number_days->profit / 100) * $this->plan->min_deposit) ) + $this->plan->min_deposit;
                }
            }
            if ($this->number_days_id) {
                $this->query_plan_number_days = plan_number_days::where('id', $this->number_days_id)->where('coin_id', $this->coin_id)->first();
                if (isset($this->query_plan_number_days)) {
                    $this->profit = $this->query_plan_number_days->profit;
                    $this->number_days = $this->query_plan_number_days->number_days;
                    $this->total_amount = ((($this->query_plan_number_days->profit / 100) * $this->plan->min_deposit)) + $this->plan->min_deposit;

                }
            }
            $this->generateQrCodeBSC();
        }
        $calculator = new InterestCalculator();
        $this->interestCalculator = $calculator->calculator_interest($this->investor);
        return view('livewire.web.deposit.deposit-modal');
    }
}