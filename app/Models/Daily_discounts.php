<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Daily_discounts extends Model
{
    use HasFactory;
    protected $table = 'daily_discounts';

    protected $fillable = [
        'plan_id',
        'discount',
        'start_date',
        'end_date',
        'status',
    ];
}
