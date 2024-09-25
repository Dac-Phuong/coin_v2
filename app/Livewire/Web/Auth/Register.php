<?php

namespace App\Livewire\Web\Auth;

use App\Mail\authMail;
use App\Models\Investors;
use App\Models\Referal_detail;
use App\Models\Referals;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Title;
use Livewire\Component;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class Register extends Component
{
    #[Title('Register')]

    public $wallets;
    public $email;
    public $confirm_email;
    public $username;
    public $fullname;
    public $password;
    public $confirm_password;
    public $question;
    public $answer;
    public $agree;
    public $ref;
    public $error = null;
    public function mount()
    {
        $this->ref = request()->input('ref');
    }
    public function submit()
    {
        $validationRules = [
            'fullname' => 'required|min:3|max:255|regex:/^[a-zA-Z0-9 ]+$/',
            'username' => [
                'required',
                'min:6',
                'max:255',
                'unique:investors,username',
                'regex:/^[a-zA-Z0-9_]+$/',
            ],
            'password' => 'required|min:6',
            'confirm_password' => 'required|min:6|same:password',
            'email' => 'required|email|unique:investors,email',
            'confirm_email' => 'required|email|same:email',
            'question' => 'required',
            'answer' => 'required',
            'agree' => 'accepted',
        ];
        $this->validate($validationRules);
        $investor = Investors::create([
            'fullname' => $this->fullname,
            'username' => $this->username,
            'email' => $this->email,
            'referal_code' => Str::random(6),
            'password' => Hash::make($this->password),
            'email_verified_at' => null,
        ]);
        $investor->save();
        if ($this->ref) {
            $check_investor = Investors::where('referal_code', $this->ref)->first();
        }
        if (isset($check_investor)) {
            $referal = Referals::first();
            if ($referal) {
                $referal_detail = Referal_detail::create([
                    'parent_code' => $check_investor->referal_code,
                    'investor_id' => $investor->id,
                    'referal_id' => $referal->id,
                    'number_referals' => 1,
                    'amount_received' => 0,
                    'status' => 0,
                ]);
                $referal_detail->save();
            }
        }
        if ($investor) {
            $this->dispatch('isShow', 'T');
            Mail::to($this->email)->send(new authMail($investor));
            $this->redirect('register/success', navigate: true);
        }
       
    }

    public function render()
    {
        return view('livewire.web.auth.register')->extends('components.layouts.app')->section('content');
    }
}
