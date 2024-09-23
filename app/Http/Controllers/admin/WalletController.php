<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function index($id)
    {
        return view('admin.wallets.index', ['id' => $id]);
    }
    public function detail()
    {
        return view('admin.wallets.detail');
    }
}