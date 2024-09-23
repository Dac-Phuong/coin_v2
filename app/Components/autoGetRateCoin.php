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
                $promises[$coin->id] = $client->getAsync($url);
            }
        }
        $responses = Utils::settle($promises)->wait();
        foreach ($responses as $coinId => $response) {
            if ($response['state'] === 'fulfilled') {
                $data = json_decode($response['value']->getBody(), true);
                if (isset($data['lastPrice'])) {
                    $coin = Coin_model::find($coinId);
                    $coin->coin_price = $data['lastPrice'];
                    $coin->save();
                }
            } else {
                Log::error("Failed to fetch price for coin ID: $coinId");
            }
        }
    }
}