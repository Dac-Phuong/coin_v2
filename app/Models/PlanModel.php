<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanModel extends Model
{
    use HasFactory;
    protected $table = 'plan_models';

    protected $fillable = [
        'name',
        'title',
        'number_date',
        'discount',
        'coin_id',
        'from_date',
        'to_date',
        'end_date',
        'min_deposit',
        'max_deposit',
        'package_type',
        'termination_fee',
        'type_date',
        'status',
    ];
    public function scopeSearch($query, $value)
    {
        $query->where('name', 'like', "%{$value}%")->orwhere('discount', 'like', "%{$value}%")->orwhere('title', 'like', "%{$value}%");
    }
    public function deposit()
    {
        return $this->belongsTo(Investor_with_plants::class);
    }
    public function wallets()
    {
        return $this->hasMany(Wallets::class);
    }
    public function coins()
    {
        return $this->belongsTo(Coin_model::class, 'coin_id', 'id');
    }
    public function planNumberDays()
    {
        return $this->hasMany(plan_number_days::class, 'plan_id', 'id');
    }
}
