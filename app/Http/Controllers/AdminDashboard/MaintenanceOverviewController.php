<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Http\Controllers\Controller;
use App\Models\MaintenanceSchedule;
use Illuminate\Http\Request;

class MaintenanceOverviewController extends Controller
{
    //Admin Maintenance Overview page view
    public function maintenanceOverview(){
        // Fetch maintenance schedules and join with vehicles and customers
        $schedules = MaintenanceSchedule::with(['vehicle.customer'])->get();
        return view('pages.admin_pages.admin_maintenance_overview', ['schedules' => $schedules]);
    }
}
