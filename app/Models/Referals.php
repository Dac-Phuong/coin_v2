<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referals extends Model
{
    use HasFactory;
    protected $table = 'referals';

    protected $fillable = [
        'amount_money',
    ];
    public function referal_detail()
    {
        return $this->belongsTo(Referal_detail::class);
    }
}
