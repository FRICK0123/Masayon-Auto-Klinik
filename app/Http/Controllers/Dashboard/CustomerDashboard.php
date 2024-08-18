<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerDashboard extends Controller
{
    //Dashboard View
    public function customerDashboardView(){
        return view('pages.customer_pages.customer_dashboard');
    }
}
