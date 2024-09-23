<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Network extends Model
{
    use HasFactory;
    protected $table = 'networks';

    protected $fillable = [
        'network_name',
        'network_image',
        'network_price',
        'description',
        'status',
    ];
    public function scopeSearch($query, $value)
    {
        $query->where('network_name', 'like', "%{$value}%")->orwhere('network_price', 'like', "%{$value}%");
    }
    public function wallet()
    {
        return $this->belongsTo(Wallets::class);
    }
}