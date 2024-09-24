<?php

namespace App\Components;

use App\Models\Coin_model;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use GuzzleHttp\Promise\Utils;

class autoGetRateCoin
{
    public function updateCoinPrice()
    {
        $client = new Client();
        $coins = Coin_model::where("rate_coin", 1)->get();
        $promises = [];
        foreach ($coins as $coin) {
            if ($coin->coin_name == "USDT") {
                $coin->coin_price = 1;
                $coin->save();
            } else {
                $url = "https://api.binance.com/api/v3/ticker/24hr?symbol={$coin->coin_name}USDT";
                $promises[] = $client->getAsync($url)->then(
                    function ($response) use ($coin) {
                        $data = json_decode($response->getBody(), true);
                        if (isset($data['lastPrice'])) {
                            $coin->coin_price = $data['lastPrice'];
                            $coin->save();
                        }
                    },
                    function () use ($coin) {
                        Log::error("Failed to fetch price for coin: {$coin->coin_name}");
                    }
                );
            }
        }
        Utils::settle($promises)->wait();
    }
}