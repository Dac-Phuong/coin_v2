<?php

namespace App\Livewire\Web\Aboutus;

use App\Models\Investors;
use Livewire\Attributes\Title;
use Livewire\Component;

class Aboutus extends Component
{
    #[Title('About Us')]
    public $investor;
    public function render()
    {
        $data_investor = session()->get("investor");
        if ($data_investor) {
            $this->investor = Investors::find($data_investor->id);
        }
        return view('livewire.web.aboutus.aboutus')->extends('components.layouts.app')->section('content');
    }
}
