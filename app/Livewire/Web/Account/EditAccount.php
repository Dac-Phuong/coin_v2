<?php

namespace App\Livewire\Web\Account;

use App\Models\Investor_wallets;
use App\Models\Investors;
use App\Models\Network;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Title;
use Livewire\Component;

class EditAccount extends Component
{
    #[Title('Edit Account')]
    public $ref;
    public $investor;
    public $email;
    public $username;
    public $fullname;
    public $password;
    public $networks;
    public $list_wallet;
    public $wallet_address;
    public $network_id;
    protected $listeners = [
        'success' => 'mount',
    ];
    public function mount()
    {
        $data_investor = session()->get('investor');
        $this->investor = Investors::find($data_investor ? $data_investor->id : '');
        $this->networks = Network::get();
        if (!$this->investor || $this->investor->status == "1") {
            return $this->redirect('/login', navigate: true);
        }
        $this->list_wallet = DB::table('investor_wallets')
            ->join('networks', 'networks.id', '=', 'investor_wallets.network_id')
            ->select('investor_wallets.*', 'networks.network_name as network_name')
            ->where('investor_id', $this->investor->id)
            ->get();
        $ref = url()->to('/');
        if ($ref && $this->investor) {
            $this->ref = $ref . '/register?ref=' . $this->investor->referal_code;
        }
        $this->username = $this->investor->username;
        $this->email = $this->investor->email;
        $this->fullname = $this->investor->fullname;

    }

    public function create_wallet()
    {
        $validationRules = [
            "network_id" => "required",
            'wallet_address' => [
                'regex:/^(0x[a-fA-F0-9]{40}|T[A-Za-z1-9]{33}|[1-9A-HJ-NP-Za-km-z]{26,48}|bc1[a-zA-HJ-NP-Z0-9]{25,62}|[a-zA-Z0-9_-]{48}|bitcoincash:[qpzry9x8gf2tvdw0s3jn54khce6mua7l|0-9a-zA-Z]{26,42}|[a-zA-Z0-9._-]+\.near|B62[a-zA-Z0-9]{50,53}|0x[a-fA-F0-9]{64})$/'
            ]
        ];
        $messages = [
            'wallet_address.regex' => 'Invalid wallet address.',
        ];
        $this->validate($validationRules, $messages);
        $investor_wallet = Investor_wallets::where('investor_id', $this->investor->id)->where('network_id', $this->network_id)->first();
        if (!$investor_wallet) {
            $investor_wallet = Investor_wallets::create([
                'network_id' => $this->network_id,
                'investor_id' => $this->investor->id,
                'wallet_address' => $this->wallet_address,
            ]);
            $investor_wallet->save();
            $this->dispatch('success', 'T');
            $this->reset();
        }
        session()->flash('error', 'Each network is only allowed to add a single wallet');
        return redirect()->back();
    }
    public function delete($wallet_id)
    {
        $investor_wallet = Investor_wallets::find($wallet_id);
        if (isset($investor_wallet)) {
            $investor_wallet->delete();
            $this->dispatch('success', 'T');
            $this->reset();
        }
    }
    public function submit()
    {
        $validationRules = [
            "email" => "required|email",
            "username" => "required",
            "fullname" => "required",
        ];
        $this->validate($validationRules);
        $this->investor->username = $this->username;
        $this->investor->fullname = $this->fullname;
        $this->investor->email = $this->email;
        if ($this->password) {
            $this->investor->password = Hash::make($this->password);
        }
        $this->investor->save();
        session()->flash('success', 'Update successfully');
    }
    public function render()
    {
        return view('livewire.web.account.edit-account')->extends('components.layouts.app')->section('content');
    }
}