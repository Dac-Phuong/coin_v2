<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallets extends Model
{
    use HasFactory;
    protected $table = 'wallets';

    protected $fillable = [
        'plan_id',
        'network_id',
        'wallet_address',
        'status',
    ];
    public function scopeSearch($query, $value)
    {
        $query->where('wallet_address', 'like', "%{$value}%");
    }
    public function investors()
    {
        return $this->belongsTo(Investors::class);
    }
    public function plan()
    {
        return $this->belongsTo(PlanModel::class);
    }
    public function network()
    {
        return $this->belongsTo(Network::class, 'network_id', 'id');
    }
}
