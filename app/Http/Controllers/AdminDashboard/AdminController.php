<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    //admin dashboard view
    public function adminDashboardView(){
        return view('pages.admin_pages.admin_dashboard');
    }
}
