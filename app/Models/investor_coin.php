<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class investor_coin extends Model
{
    use HasFactory;
    protected $table = 'investor_coins';

    protected $fillable = [
        'coin_id',
        'investor_id',
        'available_balance',
        'amount',
        'status',
    ];
}