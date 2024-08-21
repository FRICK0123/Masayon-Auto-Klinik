<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerDashboard extends Controller
{
    //Dashboard View
    public function customerDashboardView(){
        $customerID = Auth::guard('customer')->id();
        $vehicles = Vehicle::where('customerID',$customerID)->get();
        return view('pages.customer_pages.customer_dashboard',['vehicles' => $vehicles]);
    }

    //Profile View
    public function customerProfileView()
    {
        return view('pages.customer_pages.customer_profile');
    }
}
