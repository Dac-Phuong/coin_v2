<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;

class CoinController extends Controller
{
    public function index()
    {
        return view("admin.coin.index");
    }
    public function profit()
    {
        return view("admin.coin.profit");
    }
}