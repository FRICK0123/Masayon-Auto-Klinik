<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\MaintenanceHistory;
use App\Models\MaintenanceSchedule;
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
    public function customerProfileView(Request $request)
    {
        $query = MaintenanceHistory::where('customerID',Auth::guard('customer')->id());
        $transactions = $query->paginate(2)->appends($request->except('page'));
        return view('pages.customer_pages.customer_profile',['transactions'=>$transactions]);
    }

    //Maintenance Schedule View
    public function scheduleView()
    {
        $customerID = Auth::guard('customer')->id();

        $schedules = MaintenanceSchedule::join('vehicles', 'maintenance_schedules.vehicleID', '=', 'vehicles.vehicleID')
            ->where('vehicles.customerID', '=', $customerID) // Filter by the authenticated customer's ID
            ->where('maintenance_schedules.isAppointed', true)
            ->select('maintenance_schedules.*', 'vehicles.*')
            ->get();

        return view('pages.customer_pages.customer_schedule_maintenance', [
            'schedules' => $schedules,
        ]);
    }
}
