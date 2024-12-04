<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Http\Controllers\Controller;
use App\Models\MaintenanceHistory;
use App\Models\MaintenanceSchedule;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MaintenanceStatusController extends Controller
{
    //Maintenance Status Page View
    public function maintenanceStatusView(){
        $schedules = MaintenanceSchedule::with(['vehicle.customer'])
            ->where(function ($query) {
                // Condition for 'Oil Change' maintenance type
                $query->where('maintenance_type', 'Oil Change')
                    ->where(function ($subQuery) {
                        $subQuery->where('scheduled_date', '<=', Carbon::now()) // Updated to start from today
                            ->orWhereBetween('scheduled_date', [Carbon::today(), Carbon::now()->addDay(1)])
                            ->orWhereColumn('current_milage', '>=', 'next_milage_schedule');
                    })
                    ->whereNotNull('oil_type')
                    ->whereNotNull('current_milage')
                    ->whereNotNull('next_milage_schedule');
            })
            ->orWhere(function ($query) {
                // Condition for 'Oil Change' maintenance type
                $query->where('maintenance_type', 'EGR Cleaning')
                    ->where(function ($subQuery) {
                        $subQuery->where('scheduled_date', '<=', Carbon::now()) // Updated to start from today
                            ->orWhereBetween('scheduled_date', [Carbon::today(), Carbon::now()->addDay(1)])
                            ->orWhereColumn('current_milage', '>=', 'next_milage_schedule');
                    })
                    ->whereNotNull('current_milage')
                    ->whereNotNull('next_milage_schedule');
            })
            ->orWhere(function ($query) {
                // Condition for 'Oil Change' maintenance type
                $query->where('maintenance_type', 'Basic PMS')
                    ->where(function ($subQuery) {
                        $subQuery->where('scheduled_date', '<=', Carbon::now()) // Updated to start from today
                            ->orWhereBetween('scheduled_date', [Carbon::today(), Carbon::now()->addDay(1)])
                            ->orWhereColumn('current_milage', '>=', 'next_milage_schedule');
                    })
                    ->whereNotNull('current_milage')
                    ->whereNotNull('next_milage_schedule');
            })
            ->orWhere(function ($query) {
                // Condition for 'Oil Change' maintenance type
                $query->where('maintenance_type', 'Full PMS')
                    ->where(function ($subQuery) {
                        $subQuery->where('scheduled_date', '<=', Carbon::now()) // Updated to start from today
                            ->orWhereBetween('scheduled_date', [Carbon::today(), Carbon::now()->addDay(1)])
                            ->orWhereColumn('current_milage', '>=', 'next_milage_schedule');
                    })
                    ->whereNotNull('current_milage')
                    ->whereNotNull('next_milage_schedule');
            })
            ->orWhere(function ($query) {
                // Condition for non-'Oil Change' maintenance type
                $query->where('maintenance_type', '!=', 'Oil Change')
                ->where('scheduled_date', '<=', Carbon::now())
                ->orWhereBetween('scheduled_date', [Carbon::today(), Carbon::now()->addDay(1)]); // Updated to start from today
            })->where('isDeactivated', false)
            ->orderByRaw("CASE 
            WHEN maintenance_type = 'Oil Change' THEN
                CASE
                    WHEN current_milage >= next_milage_schedule THEN 0
                    WHEN scheduled_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY) THEN 1
                    ELSE 2
                END

            ELSE 
                CASE
                    WHEN scheduled_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY) THEN 1 
                    ELSE 2
                END
            END, scheduled_date ASC")
            ->get();
        return view('pages.admin_pages.admin_maintenance_status',['schedules' => $schedules]);
    }

    public function searchMaintenanceStatus(Request $request)
    {
        $query = MaintenanceSchedule::with(['vehicle.customer'])
            ->where('isDeactivated', false);

        // Check if the search query exists
        if ($request->has('search_schedule') && $request->input('search_schedule') != '') {
            $searchTerm = $request->input('search_schedule');

            // Apply search filters
            $query->where(function ($query) use ($searchTerm) {
                $query->whereHas('vehicle', function ($vehicleQuery) use ($searchTerm) {
                    $vehicleQuery->where('make', 'like', '%' . $searchTerm . '%')
                    ->orWhere('model', 'like', '%' . $searchTerm . '%')
                    ->orWhere('year_of_manufacture', 'like', '%' . $searchTerm . '%')
                    ->orWhere('plate_number', 'like', '%' . $searchTerm . '%');
                })
                    ->orWhere('maintenance_type', 'like', '%' . $searchTerm . '%')
                    ->orWhere('scheduled_date', 'like', '%' . $searchTerm . '%');
            });
        }

        // Execute the query and get results
        $schedules = $query->orderByRaw("CASE 
        WHEN maintenance_type = 'Oil Change' THEN
            CASE
                WHEN current_milage >= next_milage_schedule THEN 0
                WHEN scheduled_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY) THEN 1
                ELSE 2
            END
        ELSE 
            CASE
                WHEN scheduled_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY) THEN 1 
                ELSE 2
            END
    END, scheduled_date ASC")->get();

        // Return the view with the filtered results
        return view('pages.admin_pages.admin_maintenance_status', ['schedules' => $schedules]);
    }

    //Maintenance Status Update
    public function MaintenanceStatusUpdate(Request $request){
        $maintenanceID = $request->input('maintenance_id');
        $vehicleID = $request->input('vehicle_id');
        $customerID = $request->input('customer_id');
        $owner = $request->input('owner');
        $vehicle = $request->input('vehicle');
        $previous_milage = $request->input('previous_milage');
        $current_milage = $request->input('current_milage');
        $maintenance_type = $request->input('maintenance_type');
        $cost = $request->input('cost');
        $maintenance_description = $request->input('maintenance_description');
        $maintenance_status = "completed";
        $date_performed = Carbon::now();
        $oil_type = $request->input('oil_type');

        $maintenance_schedule = MaintenanceSchedule::where('maintenanceID',$maintenanceID)->first();
        
        if(($maintenance_type == "Oil Change" && $oil_type == "Mobil Delvac I 5W-40 Fully Synthetic Diesel Oil") || ($maintenance_type == "Oil Change" && $oil_type == "Mobil Super 5W-30 Fully Synthetic Gasoline Oil")){
            Vehicle::where('vehicleID',$vehicleID)->update(['milage'=>$current_milage]);
            $maintenance = DB::table('maintenance_schedules')->where('maintenanceID', $maintenanceID)->first();
            MaintenanceSchedule::where('maintenanceID',$maintenanceID)->update([
                'scheduled_date' => Carbon::today()->addMonths($maintenance->scheduled_interval),
                'last_maintenance_date' => Carbon::today(),
                'current_milage' => $current_milage,
                'next_milage_schedule' => $current_milage + 8000,
                'isAppointed' => true,
                'isRegarded' => false,
            ]);
            
            MaintenanceHistory::create([
                'maintenanceID' => $maintenanceID,
                'vehicleID' => $vehicleID,
                'customerID' => $customerID,
                'owner' => $owner,
                'vehicle' => $vehicle,
                'previous_milage' => $previous_milage,
                'current_milage' => $current_milage,
                'maintenance_type' => $maintenance_type,
                'oil_type' => $oil_type,
                'pms_services' => $maintenance_schedule->PMS_services,
                'cost' => $cost,
                'maintenance_description' => $maintenance_description,
                'maintenance_status' => $maintenance_status,
                'date_performed' => $date_performed
            ]);

            session()->flash('scheduled',"Maintenance/Repair for $vehicle completed");

            return to_route('maintenance_overview');
        } else if(($maintenance_type == "Oil Change" && $oil_type == "Mobil Delvac 15W-40 Semi Synthetic Diesel Oil") || ($maintenance_type == "Oil Change" && $oil_type == "Mobil Special 20w-50 Ordinary Gasoline Oil")){
            Vehicle::where('vehicleID', $vehicleID)->update(['milage' => $current_milage]);
            $maintenance = DB::table('maintenance_schedules')->where('maintenanceID', $maintenanceID)->first();
            MaintenanceSchedule::where('maintenanceID', $maintenanceID)->update([
                'scheduled_date' => Carbon::today()->addMonths($maintenance->scheduled_interval),
                'last_maintenance_date' => Carbon::today(),
                'current_milage' => $current_milage,
                'next_milage_schedule' => $current_milage + 5000,
                'isAppointed' => true,
                'isRegarded' => false,
            ]);

            MaintenanceHistory::create([
                'maintenanceID' => $maintenanceID,
                'vehicleID' => $vehicleID,
                'customerID' => $customerID,
                'owner' => $owner,
                'vehicle' => $vehicle,
                'previous_milage' => $previous_milage,
                'current_milage' => $current_milage,
                'maintenance_type' => $maintenance_type,
                'oil_type' => $oil_type,
                'pms_services' => $maintenance_schedule->PMS_services,
                'cost' => $cost,
                'maintenance_description' => $maintenance_description,
                'maintenance_status' => $maintenance_status,
                'date_performed' => $date_performed
            ]);

            session()->flash('scheduled', "Maintenance/Repair for $vehicle completed");

            return to_route('maintenance_overview');
        } else if($maintenance_type == "EGR Cleaning"){
            Vehicle::where('vehicleID', $vehicleID)->update(['milage' => $current_milage]);
            $maintenance = DB::table('maintenance_schedules')->where('maintenanceID', $maintenanceID)->first();
            MaintenanceSchedule::where('maintenanceID', $maintenanceID)->update([
                'scheduled_date' => Carbon::today()->addMonths($maintenance->scheduled_interval),
                'last_maintenance_date' => Carbon::today(),
                'current_milage' => $current_milage,
                'next_milage_schedule' => $current_milage + 50000,
                'isAppointed' => true,
                'isRegarded' => false,
            ]);

            MaintenanceHistory::create([
                'maintenanceID' => $maintenanceID,
                'vehicleID' => $vehicleID,
                'customerID' => $customerID,
                'owner' => $owner,
                'vehicle' => $vehicle,
                'previous_milage' => $previous_milage,
                'current_milage' => $current_milage,
                'maintenance_type' => $maintenance_type,
                'oil_type' => $oil_type,
                'pms_services' => $maintenance_schedule->PMS_services,
                'cost' => $cost,
                'maintenance_description' => $maintenance_description,
                'maintenance_status' => $maintenance_status,
                'date_performed' => $date_performed
            ]);

            session()->flash('scheduled', "Maintenance/Repair for $vehicle completed");

            return to_route('maintenance_overview');
        } else if($maintenance_type == "Basic PMS"){
            $oil_maintenance = MaintenanceSchedule::where('vehicleID', $vehicleID)->where('maintenance_type',"Oil Change")->first();
            if($oil_maintenance){
                if(($oil_maintenance['oil_type'] == "Mobil Delvac I 5W-40 Fully Synthetic Diesel Oil") || ($oil_maintenance['oil_type'] == "Mobil Super 5W-30 Fully Synthetic Gasoline Oil")){
                    $maintenanceOil = MaintenanceSchedule::where('vehicleID', $vehicleID)->where('maintenance_type', "Oil Change")->first();
                    MaintenanceSchedule::where('maintenanceID', $maintenanceOil->maintenanceID)->update([
                        'scheduled_date' => Carbon::today()->addMonths($maintenanceOil->scheduled_interval),
                        'last_maintenance_date' => Carbon::today(),
                        'current_milage' => $current_milage,
                        'next_milage_schedule' => $current_milage + 8000,
                        'isAppointed' => true,
                        'isRegarded' => false,
                    ]);
                }else if(($oil_maintenance['oil_type'] == "Mobil Delvac 15W-40 Semi Synthetic Diesel Oil") || ($oil_maintenance['oil_type']== "Mobil Special 20w-50 Ordinary Gasoline Oil")){
                    $maintenanceOil = MaintenanceSchedule::where('vehicleID', $vehicleID)->where('maintenance_type', "Oil Change")->first();
                    MaintenanceSchedule::where('maintenanceID', $maintenanceOil->maintenanceID)->update([
                        'scheduled_date' => Carbon::today()->addMonths($maintenanceOil->scheduled_interval),
                        'last_maintenance_date' => Carbon::today(),
                        'current_milage' => $current_milage,
                        'next_milage_schedule' => $current_milage + 5000,
                        'isAppointed' => true,
                        'isRegarded' => false,
                    ]);
                }
            }

            $brakes_maintenance = MaintenanceSchedule::where('vehicleID', $vehicleID)->where('maintenance_type', "Check Brake")->first();
            if($brakes_maintenance){
                MaintenanceSchedule::where('maintenanceID',$brakes_maintenance->maintenanceID)->update([
                'scheduled_date' => Carbon::today()->addMonths($brakes_maintenance->scheduled_interval),
                'last_maintenance_date' => Carbon::today(),
                'current_milage' => $current_milage,
                'isAppointed' => true,
                'isRegarded' => false,
                ]);
            }

            $concerns_maintenance = MaintenanceSchedule::where('vehicleID', $vehicleID)->where('maintenance_type', "Check Concerns")->first();
            if ($concerns_maintenance) {
                MaintenanceSchedule::where('maintenanceID', $concerns_maintenance->maintenanceID)->update([
                    'scheduled_date' => Carbon::today()->addMonths($concerns_maintenance->scheduled_interval),
                    'last_maintenance_date' => Carbon::today(),
                    'current_milage' => $current_milage,
                    'isAppointed' => true,
                    'isRegarded' => false,
                ]);
            }

            Vehicle::where('vehicleID', $vehicleID)->update(['milage' => $current_milage]);
            $maintenance = DB::table('maintenance_schedules')->where('maintenanceID', $maintenanceID)->first();
            MaintenanceSchedule::where('maintenanceID', $maintenanceID)->update([
                'scheduled_date' => Carbon::today()->addMonths($maintenance->scheduled_interval),
                'last_maintenance_date' => Carbon::today(),
                'current_milage' => $current_milage,
                'next_milage_schedule' => $current_milage + 5000,
                'isAppointed' => true,
                'isRegarded' => false,
            ]);

            MaintenanceHistory::create([
                'maintenanceID' => $maintenanceID,
                'vehicleID' => $vehicleID,
                'customerID' => $customerID,
                'owner' => $owner,
                'vehicle' => $vehicle,
                'previous_milage' => $previous_milage,
                'current_milage' => $current_milage,
                'maintenance_type' => $maintenance_type,
                'oil_type' => $oil_type,
                'pms_services' => $maintenance_schedule->PMS_services,
                'cost' => $cost,
                'maintenance_description' => $maintenance_description,
                'maintenance_status' => $maintenance_status,
                'date_performed' => $date_performed
            ]);
            session()->flash('scheduled', "Maintenance/Repair for $vehicle completed");

            return to_route('maintenance_overview');

        } else if($maintenance_type == "Heavy PMS"){
            $oil_maintenance = MaintenanceSchedule::where('vehicleID', $vehicleID)->where('maintenance_type', "Oil Change")->first();
            if ($oil_maintenance) {
                if (($oil_maintenance['oil_type'] == "Mobil Delvac I 5W-40 Fully Synthetic Diesel Oil") || ($oil_maintenance['oil_type'] == "Mobil Super 5W-30 Fully Synthetic Gasoline Oil")) {
                    $maintenanceOil = MaintenanceSchedule::where('vehicleID', $vehicleID)->where('maintenance_type', "Oil Change")->first();
                    MaintenanceSchedule::where('maintenanceID', $maintenanceOil->maintenanceID)->update([
                        'scheduled_date' => Carbon::today()->addMonths($maintenanceOil->scheduled_interval),
                        'last_maintenance_date' => Carbon::today(),
                        'current_milage' => $current_milage,
                        'next_milage_schedule' => $current_milage + 8000,
                        'isAppointed' => true,
                        'isRegarded' => false,
                    ]);
                } else if (($oil_maintenance['oil_type'] == "Mobil Delvac 15W-40 Semi Synthetic Diesel Oil") || ($oil_maintenance['oil_type'] == "Mobil Special 20w-50 Ordinary Gasoline Oil")) {
                    $maintenanceOil = MaintenanceSchedule::where('vehicleID', $vehicleID)->where('maintenance_type', "Oil Change")->first();
                    MaintenanceSchedule::where('maintenanceID', $maintenanceOil->maintenanceID)->update([
                        'scheduled_date' => Carbon::today()->addMonths($maintenanceOil->scheduled_interval),
                        'last_maintenance_date' => Carbon::today(),
                        'current_milage' => $current_milage,
                        'next_milage_schedule' => $current_milage + 5000,
                        'isAppointed' => true,
                        'isRegarded' => false,
                    ]);
                }
            }
            Vehicle::where('vehicleID', $vehicleID)->update(['milage' => $current_milage]);
            $maintenance = DB::table('maintenance_schedules')->where('maintenanceID', $maintenanceID)->first();
            MaintenanceSchedule::where('maintenanceID', $maintenanceID)->update([
                'scheduled_date' => Carbon::today()->addMonths($maintenance->scheduled_interval),
                'last_maintenance_date' => Carbon::today(),
                'current_milage' => $current_milage,
                'next_milage_schedule' => $current_milage + 50000,
                'isAppointed' => true,
                'isRegarded' => false,
            ]);

            MaintenanceHistory::create([
                'maintenanceID' => $maintenanceID,
                'vehicleID' => $vehicleID,
                'customerID' => $customerID,
                'owner' => $owner,
                'vehicle' => $vehicle,
                'previous_milage' => $previous_milage,
                'current_milage' => $current_milage,
                'maintenance_type' => $maintenance_type,
                'oil_type' => $oil_type,
                'pms_services' => $maintenance_schedule->PMS_services,
                'cost' => $cost,
                'maintenance_description' => $maintenance_description,
                'maintenance_status' => $maintenance_status,
                'date_performed' => $date_performed
            ]);
            session()->flash('scheduled', "Maintenance/Repair for $vehicle completed");

            return to_route('maintenance_overview');
        } else {
            Vehicle::where('vehicleID', $vehicleID)->update(['milage' => $current_milage]);
            $maintenance = DB::table('maintenance_schedules')->where('maintenanceID', $maintenanceID)->first();
            MaintenanceSchedule::where('maintenanceID', $maintenanceID)->update([
                'scheduled_date' => Carbon::today()->addMonths($maintenance->scheduled_interval),
                'last_maintenance_date' => Carbon::today(),
                'current_milage' => $current_milage,
                'isAppointed' => true,
                'isRegarded' => false,
            ]);

            MaintenanceHistory::create([
                'maintenanceID' => $maintenanceID,
                'vehicleID' => $vehicleID,
                'customerID' => $customerID,
                'owner' => $owner,
                'vehicle' => $vehicle,
                'previous_milage' => $previous_milage,
                'current_milage' => $current_milage,
                'maintenance_type' => $maintenance_type,
                'oil_type' => $oil_type,
                'pms_services' => $maintenance_schedule->PMS_services,
                'cost' => $cost,
                'maintenance_description' => $maintenance_description,
                'maintenance_status' => $maintenance_status,
                'date_performed' => $date_performed
            ]);

            session()->flash('scheduled', "Maintenance/Repair for $vehicle completed");

            return to_route('maintenance_overview');
        }
    }
}
