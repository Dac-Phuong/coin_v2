<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function plan_fixed()
    {
        return view("admin.plans.plan-fixeds");
    }
    public function plan_daily()
    {
        return view("admin.plans.plan-daily");
    }
}
