<?php

namespace App\Livewire\Web\Bounty;

use Livewire\Attributes\Title;
use Livewire\Component;

class Bounty extends Component
{
    #[Title('Bounty')] 

    public function render()
    {
        return view('livewire.web.bounty.bounty')->extends('components.layouts.app')->section('content');
    }
}
