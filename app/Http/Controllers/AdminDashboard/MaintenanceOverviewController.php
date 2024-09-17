<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Http\Controllers\Controller;
use App\Models\MaintenanceSchedule;
use Illuminate\Http\Request;

class MaintenanceOverviewController extends Controller
{
    //Admin Maintenance Overview page view
    public function maintenanceOverview()
    {
        // Fetch maintenance schedules and join with vehicles and customers
        $schedules = MaintenanceSchedule::with(['vehicle.customer'])
        ->where(function ($query) {
            // Condition for Oil Change maintenance type
            $query->where(function ($query) {
                $query->where('maintenance_type', 'Oil Change')
                    ->where(function ($query) {
                        $query->where('current_milage', '>=', 'next_milage_schedule') // Overdue oil change
                            ->orWhereBetween('scheduled_date', [now(), now()->addMonths(3)]); // Upcoming oil change
                    });
            })
                // Condition for other maintenance types
                ->orWhere(function ($query) {
                    $query->where('maintenance_type', '!=', 'Oil Change')
                        ->whereBetween('scheduled_date', [now(), now()->addMonths(3)]); // Upcoming for other types
                });
        })
        ->orderByRaw("CASE 
            WHEN maintenance_type = 'Oil Change' THEN
                CASE
                    WHEN current_milage >= next_milage_schedule THEN 0
                    WHEN scheduled_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 3 MONTH) THEN 1
                    ELSE 2
                END

            ELSE 
                CASE
                    WHEN scheduled_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 3 MONTH) THEN 1 
                    ELSE 2
                END
            END, scheduled_date ASC")
        ->get();

        return view('pages.admin_pages.admin_maintenance_overview', ['schedules' => $schedules]);
    }
}
