<?php

namespace App\Livewire\Web\Withdraw;

use App\Components\UpdateBalance;
use App\Models\Coin_model;
use App\Models\investor_coin;
use App\Models\Investor_wallets;
use App\Models\Investors;
use App\Models\Network;
use App\Models\Withdraw;
use Livewire\Component;

class ModalWithdraw extends Component
{
	public $amount = null;
	public $coins;
	public $coin = null;
	public $coin_id;
	public $coin_price;
    public $coin_fee;
	public $network_fee;
	public $min_withdraw;
	public $old_coin_price;
	public $coin_name;
	public $coin_decimal;
	public $investor;
	public $amount_received;
	public $widthdrawal_fees;
	public $wallet_address;
	public $wallet_type;
	public $wallet_name;
	public $networks;
	public $investor_coin;
	public $getWallet;
	public $network_id;
	public $updateBalance;
	public function checkbox($id = null)
	{
		$this->network_fee = 0;
		$this->network_id = null;
		$this->coin_id = $id;
		$this->coin = Coin_model::find($id);
		if ($this->coin) {
			$this->coin_price = $this->coin->coin_price;
			$this->coin_name = $this->coin->coin_name;
			$this->min_withdraw = $this->coin->min_withdraw;
			$this->coin_decimal = $this->coin->coin_decimal;
			$this->coin_fee = $this->coin->coin_fee;
		}
	}
	public function plusMax()
	{
		if ($this->getWallet && $this->investor_coin) {
			if ($this->investor_coin->available_balance >= $this->coin_fee) {
				$this->amount = $this->formatNumber($this->investor_coin->available_balance - $this->coin_fee, $this->coin_decimal);
			} else {
				$this->amount = $this->formatNumber($this->investor_coin->available_balance, $this->coin_decimal);
			}
		} else {
			if (is_null($this->network_id)) {
				session()->flash('error', 'You don\'t have a wallet for this network yet.');
				return;
			} else {
				$this->amount = 0;
			}
		}
	}
    function formatNumber($number, $decimals)
     {
         $formattedNumber = number_format($number, $decimals);
         return rtrim(rtrim($formattedNumber, '0'), '.');
     }
	// public function submit()
	// {

	// 	$this->validate([
	// 		"network_id" => "required",
	// 		'amount' => ['required', 'regex:/^[0-9.,]*$/'],
	// 	], [
	// 		'network_id.required' => 'The network field is required.'
	// 	]);

	// 	if (!isset($this->getWallet)) {
	// 		session()->flash('error', 'You dont have a wallet for this network yet.');
	// 		return redirect()->back();
	// 	}
	// 	if (!isset($this->investor_coin)) {
	// 		session()->flash('error', 'You have no balance of this coin.');
	// 		return redirect()->back();
	// 	}
	// 	$this->amount = (float) str_replace(',', '', $this->amount);
	// 	$total = $this->formatNumber($this->amount  + ($this->network_fee / $this->coin_price), $this->coin_decimal);
	// 	$total_amount = (float) str_replace(',', '', $total);
	// 	$network = Network::find($this->getWallet->network_id);
	// 	if ($this->amount >= $this->min_withdraw) {
	// 		if ($total_amount <= $this->investor_coin->available_balance) {
	// 			if (count($this->wallet_address) > 0 && isset($network)) {
	// 				$withdaw = Withdraw::create([
	// 					'investor_id' => $this->investor->id,
	// 					'amount' => $this->amount,
	// 					'total_amount' => $total_amount,
	// 					'old_coin_price' => $this->coin_price,
	// 					'wallet_address' => $this->getWallet->wallet_address,
	// 					'wallet_name' => $network->network_name,
	// 					'coin_name' => $this->coin_name,
	// 					'coin_id' => $this->coin_id,
	// 					'status' => 0,
	// 				]);
	// 				$withdaw->save();
	// 				$this->investor->balance -= $total_amount * $this->coin_price;
	// 				$this->investor_coin->available_balance -= $total_amount;
	// 				$this->investor->save();
	// 				$this->investor_coin->save();
	// 				$this->dispatch('success', 'Withdraw success.');
	// 				$this->sendMesageTelegram($withdaw);
	// 				$this->reset(['amount', 'network_id']);
	// 				$update = new UpdateBalance();
	// 				$this->updateBalance = $update->updateAccountBalance($this->investor);
	// 			} else {
	// 				session()->flash('error', 'You dont currently have a wallet. Please update your wallet information to proceed with the withdrawal.');
	// 			}
	// 		} else {
	// 			session()->flash('error', 'Account balance is not enough to withdraw.');
	// 		}
	// 	} else {
	// 		session()->flash('error', 'Minimum withdrawal amount is ' . $this->min_withdraw . ' ' . $this->coin_name);
	// 	}
	// }
	public function submit()
	{
		// Validate input data
		$this->validate([
			'network_id' => 'required',
			'amount' => ['required', 'regex:/^[0-9.,]*$/'],
		], [
			'network_id.required' => 'The network field is required.',
		]);

		// Check if the wallet exists for the network
		if (!isset($this->getWallet)) {
			session()->flash('error1', 'You don\'t have a wallet for this network yet.');
			return redirect()->back();
		}

		// Check if the investor has balance for the coin
		if (!isset($this->investor_coin)) {
			session()->flash('error', 'You have no balance of this coin.');
			return redirect()->back();
		}

		// Remove commas from the amount and calculate total amount
		$this->amount = (float) str_replace(',', '', $this->amount);
		$total = $this->formatNumber($this->amount + $this->coin_fee, $this->coin_decimal);
		$total_amount = (float) str_replace(',', '', $total);
		// Find network by wallet's network ID
		$network = Network::find($this->getWallet->network_id);

		// Check if amount is less than minimum withdrawal
		if ($this->amount < $this->min_withdraw) {
			session()->flash('error', 'Minimum withdrawal amount is ' . $this->min_withdraw . ' ' . $this->coin_name);
			return redirect()->back();
		}
		// Check if the total amount exceeds the available balance
		if ($total_amount > $this->investor_coin->available_balance) {
			session()->flash('error', 'Account balance is not enough to withdraw.');
			return redirect()->back();
		}

		// Check if wallet address is set and network exists
		if (count($this->wallet_address) === 0 || !isset($network)) {
			session()->flash('error', 'You don\'t currently have a wallet. Please update your wallet information to proceed with the withdrawal.');
			return redirect()->back();
		}

		// Create a new withdrawal record
		$withdraw = Withdraw::create([
			'investor_id' => $this->investor->id,
			'amount' => $this->amount,
			'total_amount' => $total_amount,
			'old_coin_price' => $this->coin_price,
			'wallet_address' => $this->getWallet->wallet_address,
			'wallet_name' => $network->network_name,
			'coin_name' => $this->coin_name,
			'coin_id' => $this->coin_id,
			'status' => 0,
		]);

		// Update investor and coin balances
		$this->investor->balance -= $total_amount * $this->coin_price;
		$this->investor_coin->available_balance -= $total_amount;
		$this->investor->save();
		$this->investor_coin->save();

		// Dispatch success message and perform additional actions
		$this->dispatch('success', 'Withdraw success.');
		$this->sendMesageTelegram($withdraw);
		$this->reset(['amount', 'network_id']);
		// Update account balance
		$update = new UpdateBalance();
		$this->updateBalance = $update->updateAccountBalance($this->investor);
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
		✨================⚡️⚡️⚡️⚡️⚡️===================✨
		✨============= LỆNH RÚT TIỀN =============
		✨===============⚡️⚡️⚡️⚡️⚡️===================
		✨Số tiền : $" . $invertPlant['amount'] . "
		✨Trạng Thái : " . $status . "
		✨Tên : " . $this->investor->username . "
		✨Email : " . $this->investor->email . "
		✨Địa chỉ ví nhận : " . $this->wallet_type . "
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
		$data_investor = session()->get('investor');
		if (!$data_investor) {
			return $this->redirect('/login', navigate: true);
		}
		$this->investor = Investors::find($data_investor->id);
		$this->coins = Coin_model::where('status', 0)->get();
		if (isset($this->network_id) || isset($this->coin_id)) {
			$coin = Coin_model::find($this->coin_id);
			$this->investor_coin = investor_coin::where('investor_id', $this->investor->id)->where('coin_id', $coin->id)->first();
			$this->getWallet = Investor_wallets::where('investor_id', $this->investor->id)->where('network_id', $this->network_id)->first();
			if (!isset($this->getWallet) && isset($this->network_id) && !empty($this->network_id)) {
				session()->flash('error1', 'You don\'t have a wallet for this network yet');
			}
			$this->network_fee = Network::find($this->network_id)->network_price ?? 0;
			if (isset($coin)) {
				$array_id = array_filter(explode(',', str_replace(['[', ']', '"'], '', $coin->network_id)));
				$this->networks = Network::whereIn('id', $array_id)->where('status', 0)->orderBy('created_at', 'asc')->get();
			}
		} else {
			$this->coin = Coin_model::where('status', 0)->first();
			if (isset($this->coin)) {
				$array_id = array_filter(explode(',', str_replace(['[', ']', '"'], '', $this->coin->network_id)));
				$this->networks = Network::whereIn('id', $array_id)->where('status', 0)->orderBy('created_at', 'asc')->get();
				$this->investor_coin = investor_coin::where('investor_id', $this->investor->id)->where('coin_id', $this->coin->id)->first();
				$this->coin_id = $this->coin->id;
				$this->coin_price = $this->coin->coin_price;
				$this->coin_name = $this->coin->coin_name;
				$this->coin_decimal = $this->coin->coin_decimal;
				$this->coin_fee = $this->coin->coin_fee;
				$this->min_withdraw = $this->coin->min_withdraw;
			}
		}
		$this->wallet_address = Investor_wallets::where('investor_id', $this->investor->id)->get();
		return view('livewire.web.withdraw.modal-withdraw');
	}
}