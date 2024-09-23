<?php

namespace App\Livewire\Admin\Investors;

use App\Models\Investors;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class ListInvestor extends Component
{
    use WithPagination;
    public $investors;
    public $search = '';
    public $perpage = 20;
    public $id;
    public $toggleState = false;
    protected $listeners = [
        'success' => 'render',
        'delete' => 'delete',
        'update' => 'render'
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
        $investor = Investors::find($id);
        if (!is_null($investor)) {
            DB::table('investor_with_plants')
                ->join('wallets', 'wallets.id', '=', 'investor_with_plants.wallet_id')
                ->where('investor_with_plants.investor_id', $investor->id)
                ->where('wallets.status', 1)
                ->update(['wallets.status' => 0]);
            $investor->delete();
        }
        $this->dispatch('success', 'Successful investor deletion.');
    }
    public function render()
    {
        $this->investors = Investors::all();
        return view('livewire.admin.investors.list-investor', ['list_investor' => Investors::search($this->search)->orderBy('created_at', 'desc')->paginate($this->perpage)]);
    }
}