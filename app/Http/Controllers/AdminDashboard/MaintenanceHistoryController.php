<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Http\Controllers\Controller;
use App\Models\MaintenanceHistory;
use Illuminate\Http\Request;

class MaintenanceHistoryController extends Controller
{
    //Maintenance History Page View
    public function maintenanceHistoryView(){
        $histories = MaintenanceHistory::orderBy('date_performed','asc')->get();
        return view('pages.admin_pages.admin_maintenance_history',['histories'=>$histories]);
    }
}
