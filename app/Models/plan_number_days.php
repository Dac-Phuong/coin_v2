<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class plan_number_days extends Model
{
    use HasFactory;
    protected $table = 'plan_number_days';

    protected $fillable = [
        'number_days',
        'profit',
        'plan_id',
        'coin_id'
    ];
    public function planModel()
    {
        return $this->belongsTo(PlanModel::class);
    }
}
