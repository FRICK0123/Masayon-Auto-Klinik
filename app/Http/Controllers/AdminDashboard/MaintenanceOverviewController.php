<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Http\Controllers\Controller;
use App\Models\MaintenanceSchedule;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MaintenanceOverviewController extends Controller
{
    //Admin Maintenance Overview page view
    public function maintenanceOverview(Request $request)
    {
        // Fetch maintenance schedules and join with vehicles and customers
        $query = MaintenanceSchedule::join('vehicles', 'vehicles.vehicleID', '=', 'maintenance_schedules.vehicleID')
        ->join('customers', 'customers.customerID', '=', 'vehicles.customerID')
        ->with(['vehicle.customer'])
        ->where('maintenance_schedules.isAppointed', true)
        ->where('maintenance_schedules.isDeactivated', false)
        ->orderByRaw("CASE 
            WHEN maintenance_type = 'Oil Change' THEN
                CASE
                    WHEN current_milage >= next_milage_schedule THEN 0
                    WHEN scheduled_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY) THEN 1
                    ELSE 2
                END
            WHEN maintenance_type = 'EGR Cleaning' THEN
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
            END, scheduled_date ASC");

        // Check if there is a search term and filter the results
        if ($request->has('search_schedule') && $request->input('search_schedule') !== ''
        ) {
            $searchTerm = $request->input('search_schedule');

            // Add where clauses to search for the term in multiple columns
            $query->where(function ($query) use ($searchTerm) {
                $query->where('vehicles.make', 'LIKE', "%$searchTerm%")
                ->orWhere('vehicles.model',
                    'LIKE',
                    "%$searchTerm%"
                )
                ->orWhere('vehicles.plate_number', 'LIKE', "%$searchTerm%")
                ->orWhere('vehicles.year_of_manufacture', 'LIKE', "%$searchTerm%")
                ->orWhere('maintenance_schedules.maintenance_type', 'LIKE', "%$searchTerm%")
                ->orWhere('customers.fullname', 'LIKE', "%$searchTerm%");
            });
        }

        // Get the schedules
        $schedules = $query->get();

        return view('pages.admin_pages.admin_maintenance_overview', ['schedules' => $schedules]);
    }

    //Delete Maintenance schedule modal
    public function deleteMaintenance($maintenanceID){
        $schedule = MaintenanceSchedule::where('maintenanceID', $maintenanceID)->first();
        $schedule->delete();

        session()->flash('schedule_deleted',"Maintenance Schedule Successfully Deleted");
        return to_route('maintenance_overview');
    }

    public function maintenanceByDateRange(Request $request)
    {
        // Parse and validate the dates
        $startDate = Carbon::parse($request->input('start_date'))->startOfDay();
        $endDate = Carbon::parse($request->input('end_date'))->endOfDay();

        // Fetch maintenance schedules and join with vehicles and customers
        $schedules = MaintenanceSchedule::join('vehicles', 'vehicles.vehicleID', '=', 'maintenance_schedules.vehicleID')
        ->join('customers', 'customers.customerID', '=', 'vehicles.customerID')
        ->whereBetween('maintenance_schedules.scheduled_date', [$startDate, $endDate])
            ->where('maintenance_schedules.isAppointed', true)
            ->where('maintenance_schedules.isDeactivated', false)
            ->orderByRaw("CASE 
            WHEN maintenance_type = 'Oil Change' THEN
                CASE
                    WHEN current_milage >= next_milage_schedule THEN 0
                    WHEN scheduled_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY) THEN 1
                    ELSE 2
                END
            WHEN maintenance_type = 'EGR Cleaning' THEN
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
            ->select('maintenance_schedules.*', 'vehicles.*', 'customers.fullname as customer_name')
            ->get();

        return view('pages.admin_pages.admin_maintenance_overview', [
            'schedules' => $schedules,
        ]);
    }

}
