<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Http\Controllers\Controller;
use App\Models\MaintenanceSchedule;
use Illuminate\Http\Request;

class AdminAppointmentController extends Controller
{
    //Admin Appointment Controller View
    public function adminAppointmentView(){
        $schedules = MaintenanceSchedule::join('vehicles', 'maintenance_schedules.vehicleID', '=', 'vehicles.vehicleID')
            ->where('maintenance_schedules.isAppointed', false)
            ->select('maintenance_schedules.*', 'vehicles.*')
            ->get();

        return view('pages.admin_pages.admin_appointment', [
            'schedules' => $schedules,
        ]);
    }
}
