<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Http\Controllers\Controller;
use App\Models\MaintenanceSchedule;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
                // Condition for non-'Oil Change' maintenance type
                $query->where('maintenance_type', '!=', 'Oil Change')
                ->where('scheduled_date', '<=', Carbon::now())
                ->orWhereBetween('scheduled_date', [Carbon::today(), Carbon::now()->addDay(1)]); // Updated to start from today
            })->orderByRaw("CASE 
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
        
        //Brainstorm for ways in code to handle updating the data in database when the admin marks the status completed
    }
}
