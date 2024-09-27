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
        $vehicle = Vehicle::where('vehicleID', $vehicleID)->first();
        return view('pages.customer_pages.schedule_maintenance', ['vehicle' => $vehicle]);
    }

    //Maintenance Schedule Form Submittion
    public function scheduleMaintenance(Request $request){
        $vehicleID = $request->input('vehicleID');
        $maintenance_type = $request->input('maintenance_type');
        $maintenance_date = $request->input('maintenance_date');
        $scheduled_interval = $request->input('scheduled_interval');
        $last_maintenance_date = $request->input('maintenance_date');
        $oil_type = $request->input('oil_type');
        $milage = $request->input('milage');
        $milage_interval = $request->input('mileage_interval');

        if($maintenance_type == "Oil Change"){
            MaintenanceSchedule::create([
                'vehicleID' => $vehicleID,
                'maintenance_type' => $maintenance_type,
                'scheduled_date' => Carbon::parse($maintenance_date)->addMonths($scheduled_interval),
                'last_maintenance_date' => $last_maintenance_date,
                'scheduled_interval' => $scheduled_interval,
                'oil_type' => $oil_type,
                'current_milage' => $milage,
                'next_milage_schedule' => $milage + $milage_interval,
            ]);
        } else if($maintenance_type == "EGR Cleaning"){
            MaintenanceSchedule::create([
                'vehicleID' => $vehicleID,
                'maintenance_type' => $maintenance_type,
                'scheduled_date' => Carbon::parse($maintenance_date)->addMonths(48),
                'last_maintenance_date' => $last_maintenance_date,
                'scheduled_interval' => 48,
                'oil_type' => null,
                'current_milage' => $milage,
                'next_milage_schedule' => $milage + 50000,
            ]);
        } else if($maintenance_type == "Basic PMS"){
            MaintenanceSchedule::create([
                'vehicleID' => $vehicleID,
                'maintenance_type' => $maintenance_type,
                'scheduled_date' => Carbon::parse($maintenance_date)->addMonths($scheduled_interval),
                'last_maintenance_date' => $last_maintenance_date,
                'scheduled_interval' => $scheduled_interval,
                'oil_type' => null,
                'current_milage' => $milage,
                'next_milage_schedule' => $milage + 5000,
            ]);
        } else {
            MaintenanceSchedule::create([
                'vehicleID' => $vehicleID,
                'maintenance_type' => $maintenance_type,
                'scheduled_date' => Carbon::parse($maintenance_date)->addMonths($scheduled_interval),
                'last_maintenance_date' => $last_maintenance_date,
                'scheduled_interval' => $scheduled_interval,
                'oil_type' => null,
                'current_milage' => null,
                'next_milage_schedule' => null,
            ]);
        }

        return to_route('customer_maintenance_schedule');
    }
}
