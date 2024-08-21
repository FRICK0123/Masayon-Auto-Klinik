<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\MaintenanceSchedule;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaintenanceController extends Controller
{

    //Maintenance Schedule Form View
    public function scheduleMaintenanceView($vehicleID){
        $existingMaintenance = MaintenanceSchedule::where('vehicleID', $vehicleID)->first();

        if(!$existingMaintenance){
            $vehicle = Vehicle::where('vehicleID', $vehicleID)->first();
            return view('pages.customer_pages.schedule_maintenance', ['vehicle' => $vehicle]);
        } else {
            return to_route('customer_maintenance_schedule');
        }
    }

    //Maintenance Schedule Form Submittion
    public function scheduleMaintenance(Request $request){
        $vehicleID = $request->input('vehicleID');
        $maintenance_type = $request->input('maintenance_type');
        $maintenance_date = $request->input('maintenance_date');
        $scheduled_interval = $request->input('scheduled_interval');
        $last_maintenance_date = $request->input('maintenance_date');

        MaintenanceSchedule::create([
            'vehicleID' => $vehicleID,
            'maintenance_type' => $maintenance_type,
            'scheduled_date' => Carbon::parse($maintenance_date)->addMonths($scheduled_interval),
            'last_maintenance_date' => $last_maintenance_date,
            'scheduled_interval' => $scheduled_interval,
        ]);

        return to_route('customer_maintenance_schedule');
    }
}
