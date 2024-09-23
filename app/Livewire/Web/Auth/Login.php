<?php

namespace App\Livewire\Web\Auth;

use App\Models\Investors;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Title;
use Livewire\Component;

class Login extends Component
{
    #[Title('Login')]

    public $username;
    public $password;

    public function submit()
    {
        $this->validate([
            "username" => "required|min:3|max:255",
            "password" => "required",
        ]);
        $investor = Investors::where('username', $this->username)->first();
        if ($investor && Hash::check($this->password, $investor->password)) {
           
            if ($investor->status !== "1") {
                if ($investor->email_verified_at !== null) {
                    session(['investor' => $investor]);
                    return $this->redirect('/account', navigate: true);
                } else {
                    session()->flash('error', 'Your account has not been verified gmail. Please authenticate your gmail account before logging in.');
                }
            } else {
                session()->flash('error', 'Your account has been locked, please contact the administrator to be unlocked.');
            }
        } else {
            session()->flash('error', 'Your login or password  is wrong. Please check information.');
        }
    }


    public function render()
    {
        return view('livewire.web.auth.login')->extends('components.layouts.app')->section('content');
    }
}