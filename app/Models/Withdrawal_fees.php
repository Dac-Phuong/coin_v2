<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdrawal_fees extends Model
{
    use HasFactory;
    protected $table = 'withdrawal_fees';

    protected $fillable = [
        'amount_money',
        'min_amount',
    ];
}
