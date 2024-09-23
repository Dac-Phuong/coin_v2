<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Investor_with_plants extends Model
{
    use HasFactory;
    protected $table = 'investor_with_plants';

    protected $fillable = [
        'plan_id',
        'coin_id',
        'investor_id',
        'total_last_seconds',
        'profit',
        'amount',
        'total_amount',
        'number_days',
        'type_payment',
        'wallet_id',
        'wallet_address',
        'network_name',
        'network_fee',
        'name_coin',
        'calculate_money',
        'current_coin_price',
        'total_coin_price',
        'status',
    ];
    public function scopeSearch($query, $value)
    {
        $query->where('name_coin', 'like', "%{$value}%")->orwhere('total_amount', 'like', "%{$value}%");
    }
    public function plan()
    {
        return $this->hasMany(PlanModel::class);
    }
    public function investor()
    {
        return $this->hasMany(Investors::class);
    }
}