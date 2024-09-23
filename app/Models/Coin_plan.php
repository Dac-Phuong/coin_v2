<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coin_plan extends Model
{
    use HasFactory;
    protected $table = 'coin_plans';

    protected $fillable = [
        'coin_id',
        'plan_id',
        'profit',
        'number_days',
        'status',
    ];
}