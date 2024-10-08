<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\MaintenanceSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    //Schedule Appointment View
    public function appointmentView(){
        $customerID = Auth::guard('customer')->id();

        $schedules = MaintenanceSchedule::join('vehicles', 'maintenance_schedules.vehicleID', '=', 'vehicles.vehicleID')
            ->where('vehicles.customerID', '=', $customerID) // Filter by the authenticated customer's ID
            ->where('maintenance_schedules.isAppointed', false)
            ->select('maintenance_schedules.*', 'vehicles.*')
            ->get();

        return view('pages.customer_pages.schedule_appointment', [
            'schedules' => $schedules,
        ]);
    }
}
