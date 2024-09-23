<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Investor_wallets extends Model
{
    use HasFactory;
    protected $table = 'investor_wallets';

    protected $fillable = [
        'wallet_address',
        'network_id',
        'investor_id',
        'status',
    ];
}