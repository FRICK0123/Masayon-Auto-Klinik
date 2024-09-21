<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MaintenanceHistoryController extends Controller
{
    //Maintenance History Page View
    public function maintenanceHistoryView(){
        return view('pages.admin_pages.admin_maintenance_history');
    }
}
