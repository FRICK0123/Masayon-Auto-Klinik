<?php

namespace App\Http\Controllers\ManagerDashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManagerDashboardController extends Controller
{
    //Manager Dashboard View
    public function managerDashboardView(){
        return view('pages.manager_pages.manager_dashboard');
    }
}
