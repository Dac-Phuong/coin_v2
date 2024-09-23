<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model
{
    use HasFactory;
    protected $table = 'withdraws';

    protected $fillable = [
        'investor_id',
        'amount',
        'wallet_address',
        'wallet_name',
        'coin_name',
        'coin_id',
        'total_amount',
        'old_coin_price',
        'status',
    ];
    public function scopeSearch($query, $value)
    {
        $query->where('amount', 'like', "%{$value}%")->orwhere('coin_name', 'like', "%{$value}%")->orwhere('wallet_name', 'like', "%{$value}%");
    }
    public function investors()
    {
        return $this->belongsTo(Investors::class);
    }
}