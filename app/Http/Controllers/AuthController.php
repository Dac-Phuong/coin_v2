<?php

namespace App\Http\Controllers;

use App\Models\Investors;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function logout()
    {
        $investor = optional(session('investor'))->id;
        if ($investor) {
            session()->forget('investor');
        }
        return redirect()->to('/');
    }
    public function verifyEmail($id)
    {
        $investor = Investors::findOrFail($id);
        if (isset($investor) && $investor->email_verified_at == null) {
            $investor->email_verified_at = now();
            $investor->save();
            session()->flash('success', 'Account verification successful, please log in.');
            return redirect()->to('/login');
        } else {
            return redirect()->to('/register');
        }
    }
}
