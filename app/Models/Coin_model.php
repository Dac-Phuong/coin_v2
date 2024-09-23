<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coin_model extends Model
{
    use HasFactory;
    protected $table = 'coin_models';

    protected $fillable = [
        'coin_name',
        'coin_price',
        'coin_image',
        'coin_fee',
        'min_withdraw',
        'coin_decimal',
        'rate_coin',
        'network_id',
        'status',
        'description',
    ];
    public function scopeSearch($query, $value)
    {
        $query->where('coin_name', 'like', "%{$value}%")->orwhere('coin_price', 'like', "%{$value}%");
    }
}