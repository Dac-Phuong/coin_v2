<?php

namespace App\Livewire\Admin\Network;

use App\Models\Network;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class UpdateNetwork extends Component
{
    use WithFileUploads;
    public $network_name;
    public $network_image;
    public $network_price;
    public $networks;
    public $description;
    public $status = 0;
    protected $listeners = ['update' => 'mount'];

    public function mount($id = null)
    {
        $this->networks = Network::find($id);
        if ($this->networks) {
            $this->network_name = $this->networks->network_name;
            $this->network_price = $this->networks->network_price;
            $this->description = $this->networks->description;
            $this->status = $this->networks->status;
        }
    }
    public function submit()
    {
        try {
            $this->networks->network_name = $this->network_name;
            $this->networks->network_price = $this->network_price;
            $this->networks->description = $this->description;
            $this->networks->status = $this->status;
            if ($this->network_image) {
                $this->validate([
                    'network_image' => 'required|image|max:1024',
                ]);
                $image = $this->network_image;
                $ext = $image->extension();
                $imageName = time() . '-image.' . $ext;
                $imagePath = 'uploads/' . $imageName;
                $image->storeAs('public', $imagePath);
                $imageUrl = Storage::url($imagePath);
                $this->networks->network_image = $imageUrl;
            }
            $this->networks->save();
            $this->dispatch('success', 'Updated successfully.');
            $this->reset(['network_name', 'network_image', 'description', 'network_image', 'status']);
        } catch (\Exception $e) {
            $this->dispatch('error', 'There was an error updating the network.');
            Log::error('Wallet update error: ' . $e->getMessage());
        }
    }
    public function render()
    {
        return view('livewire.admin.network.update-network');
    }
}