<?php

namespace App\Livewire\Web\Faq;

use Livewire\Attributes\Title;
use Livewire\Component;

class Faq extends Component
{
    #[Title('Faq')] 
    public function render()
    {
        return view('livewire.web.faq.faq')->extends('components.layouts.app')->section('content');
    }
}
