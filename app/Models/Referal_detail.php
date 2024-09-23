<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referal_detail extends Model
{
    use HasFactory;
    protected $fillable = [
        'investor_id',
        'parent_code',
        'referal_id',
        'coin_id',
        'amount_received',
        'number_referals',
        'status',
    ];
    public function referals()
    {
        return $this->hasMany(Referals::class);
    }
    public function investor()
    {
        return $this->hasMany(Investors::class);
    }
}
