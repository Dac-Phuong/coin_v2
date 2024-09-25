<?php

namespace App\Components;

use Illuminate\Support\Facades\DB;

class UpdateBalance
{
    public function updateAccountBalance($investor)
    {
        if ($investor) {
            // Calculate total balance
            $total_balance = DB::table('investor_coins')
                ->join('coin_models', 'investor_coins.coin_id', '=', 'coin_models.id')
                ->where('investor_coins.investor_id', $investor->id)
                ->sum(DB::raw('investor_coins.available_balance * coin_models.coin_price'));
            $investor->balance = $total_balance;
            $investor->save();
        }
    }
}