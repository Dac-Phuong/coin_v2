<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Investors extends Model
{
    use HasFactory;
    protected $table = 'investors';

    protected $fillable = [
        'fullname',
        'username',
        'email',
        'password',
        'referal_code',
        'balance',
        'earned_toatl',
        'wallet_address',
        'email_verified_at',
        'status',
    ];
    public function scopeSearch($query, $value)
    {
        $query->where('fullname', 'like', "%{$value}%")->orwhere('email', 'like', "%{$value}%")->orwhere('username', 'like', "%{$value}%");
    }
    public function wallets()
    {
        return $this->hasMany(Wallets::class);
    }
    public function withdraw()
    {
        return $this->hasMany(Withdraw::class);
    }
    public function investorWithPlans()
    {
        return $this->belongsTo(Investor_with_plants::class);
    }
    public function referal_detail()
    {
        return $this->belongsTo(Referal_detail::class);
    }
}
