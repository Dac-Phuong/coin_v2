<?php

namespace App\Livewire\Admin\Coin;

use App\Models\Coin_model;
use App\Models\Network;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class UpdateCoin extends Component
{
    use WithFileUploads;
    public $network;
    public $coins;
    public $coin_name;
    public $coin_image;
    public $coin_price;
    public $coin_fee;
    public $min_withdraw;
    public $rate_coin;
    public $description;
    public $status = 0;
    public $coin_decimal;
    public $network_id = [];
    protected $listeners = ['update' => 'mount'];
    public function mount($id = null)
    {
        $this->coins = Coin_model::find($id);
        if ($this->coins) {
            $this->coin_name = $this->coins->coin_name;
            $this->network_id = array_filter(explode(',', str_replace(['[', ']', '"'], '', $this->coins->network_id)));
            $this->rate_coin = $this->coins->rate_coin;
            $this->coin_price = $this->coins->coin_price;
            $this->coin_decimal = $this->coins->coin_decimal;
            $this->description = $this->coins->description;
            $this->coin_fee = $this->coins->coin_fee;
            $this->min_withdraw = $this->coins->min_withdraw;
            $this->status = $this->coins->status;
        }
    }
    public function submit()
    {
        try {
            if ($this->coin_image) {
                $this->validate([
                    'coin_image' => 'required|image|max:1024',
                ]);
                $image = $this->coin_image;
                $ext = $image->extension();
                $imageName = time() . '-image.' . $ext;
                $imagePath = 'uploads/' . $imageName;
                $image->storeAs('public', $imagePath);
                $imageUrl = Storage::url($imagePath);
                $this->coins->coin_image = $imageUrl;
            }
            $this->coins->coin_name = trim($this->coin_name);
            $this->coins->network_id = $this->network_id;
            $this->coins->rate_coin = $this->rate_coin;
            $this->coins->coin_decimal = $this->coin_decimal;
            $this->coins->coin_price = $this->coin_price;
            $this->coins->coin_fee = $this->coin_fee;
            $this->coins->min_withdraw = $this->min_withdraw;
            $this->coins->description = $this->description;
            $this->coins->status = $this->status;
            $this->coins->save();
            $this->dispatch('success', 'Updated successfully.');
        } catch (\Exception $e) {
            $this->dispatch('error', 'There was an error updating the network.');
            Log::error('Coin update error: ' . $e->getMessage());
        }
    }
    public function render()
    {
        $this->network = Network::get();
        return view('livewire.admin.coin.update-coin');
    }
}