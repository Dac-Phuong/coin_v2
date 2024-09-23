<?php

namespace App\Livewire\Admin\Coin;

use App\Models\Coin_model;
use App\Models\Network;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateCoin extends Component
{
    use WithFileUploads;
    public $network;
    public $coin_name;
    public $min_withdraw;
    public $coin_price = 0;
    public $coin_decimal = 4;
    public $coin_image;
    public $coin_fee;
    public $rate_coin = 0;
    public $description;
    public $status = 0;
    public $network_id = [];
    public function submit()
    {
        $this->validate([
            'coin_name' => 'required',
            'coin_price' => 'required',
            'coin_decimal' => 'required',
            'min_withdraw' => 'required',
            'coin_fee' => 'required',
            'coin_image' => 'required|image|max:1024',
        ]);

        try {
            $image = $this->coin_image;
            $ext = $image->extension();
            $imageName = time() . '-image.' . $ext;
            $imagePath = 'uploads/' . $imageName;
            $image->storeAs('public', $imagePath);
            $imageUrl = Storage::url($imagePath);
            $coin = Coin_model::create([
                'coin_name' => trim($this->coin_name),
                'coin_price' => $this->coin_price,
                'coin_decimal' => $this->coin_decimal,
                'rate_coin' => $this->rate_coin,
                'min_withdraw' => $this->min_withdraw,
                'coin_fee' => $this->coin_fee,
                'coin_image' => $imageUrl,
                'network_id' => json_encode($this->network_id),
                'description' => $this->description,
                'status' => $this->status,
            ]);
            $coin->save();
            $this->dispatch('success', 'Add coin successfully.');
            $this->reset();
        } catch (\Exception $e) {
            $this->dispatch('error', $e->getMessage());
        }
    }
    public function render()
    {
        $this->network = Network::get();
        return view('livewire.admin.coin.create-coin');
    }
}