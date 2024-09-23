<?php

namespace App\Livewire\Admin\Coin;

use App\Components\autoGetRateCoin;
use App\Models\Coin_model;
use App\Models\Network;
use Livewire\Component;

class ListCoin extends Component
{
    public $perpage = 20;
    public $autoGetRateCoins;
    public $search = '';
    public $id;
    public $toggleState = false;
    protected $listeners = [
        'success' => 'render',
        'delete' => 'delete'
    ];
    public function toggle($id = null)
    {
        if ($id != $this->id) {
            $this->id = $id;
            $this->toggleState = true;
        } else {
            $this->toggleState = !$this->toggleState;
        }
    }
    public function closeToggle()
    {
        $this->toggleState = false;
    }
    public function delete($id)
    {
        $coin = Coin_model::find($id);
        if (!is_null($coin)) {
            $coin->delete();
            $this->dispatch('success', 'Delete successfully.');
        } else {
            $this->dispatch('error', 'Delete Faild.');
        }
    }
    public function render()
    {
        $list_coin = Coin_model::search($this->search)->orderBy('created_at', 'DESC')->paginate($this->perpage);
        foreach ($list_coin as $key => $value) {
            $array_id = array_filter(explode(',', str_replace(['[', ']', '"'], '', $value->network_id)));
            $network_names = Network::whereIn('id', $array_id)->pluck('network_name')->toArray();
            $list_coin[$key]->network_name = $network_names;
        }
        $autoUpdateRateCoins = new autoGetRateCoin();
        $this->autoGetRateCoins = $autoUpdateRateCoins->updateCoinPrice();
        return view('livewire.admin.coin.list-coin', ['list_coin' => $list_coin]);
    }
}