<?php

namespace App\Livewire\Admin\Investors;

use App\Models\Withdraw;
use Livewire\Component;

class HistoryWithdraw extends Component
{
    public $id;
    public $search = '';
    public $perpage = 20;
    public function mount($id)
    {
        $this->id = $id;
    }
    public function render()
    {

        return view('livewire.admin.investors.history-withdraw', ['history_withdraw' => Withdraw::search($this->search)->where('investor_id', $this->id)->orderBy('created_at', 'desc')->paginate($this->perpage)]);
    }
}