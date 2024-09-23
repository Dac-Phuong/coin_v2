<?php

namespace App\Livewire\Web\Auth;

use App\Models\Investors;
use Livewire\Attributes\Title;
use Livewire\Component;
use Illuminate\Support\Str;
use App\Mail\authMail;
use App\Mail\recover as MailRecover;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

class Recover extends Component
{
    #[Title('Recover')]
    public $email;
    public function submit()
    {
        $this->validate([
            'email' => 'required|email',
        ]);
        $investor = Investors::where('email', $this->email)->first();
        if ($investor) {
            $new_password = Str::random(6);
            $investor->password = Hash::make($new_password);
            $investor->save();
            Mail::to($this->email)->send(new MailRecover($new_password));
            session()->flash('success', 'Password has been sent to your email, Please check email.');
        } else {
            session()->flash('error', 'This email address does not exist.');
        }
    }
    public function render()
    {
        return view('livewire.web.auth.recover')->extends('components.layouts.app')->section('content');
    }
}