<?php

namespace App\Livewire\Admin\Network;

use App\Models\Network;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateNetwork extends Component
{
    use WithFileUploads;
    public $network_name;
    public $network_image;
    public $description;
    public $network_price;
    public $status = 0;
    public $network;
    public function submit()
    {
        $this->validate([
            'network_name' => 'required|regex:/^[a-zA-Z0-9\s.,_-]+$/',
            'network_price' => 'required|numeric',
            'network_image' => 'required|image|max:1024',
        ]);
        try {
            $image = $this->network_image;
            $ext = $image->extension();
            $imageName = time() . '-image.' . $ext;
            $imagePath = 'uploads/' . $imageName;
            $image->storeAs('public', $imagePath);
            $imageUrl = Storage::url($imagePath);
            $network = Network::create([
                'network_name' => $this->network_name,
                'network_image' => $imageUrl,
                'network_price' => $this->network_price,
                'description' => $this->description,
                'status' => $this->status,
            ]);
            $network->save();
            $this->dispatch('success', 'Add network successfully.');
        } catch (\Exception $e) {
            $this->dispatch('error', $e->getMessage());
        }
        $this->reset();
    }
    public function render()
    {
        return view('livewire.admin.network.create-network');
    }
}