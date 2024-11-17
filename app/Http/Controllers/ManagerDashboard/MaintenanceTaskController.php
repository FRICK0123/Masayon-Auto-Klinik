<?php

namespace App\Http\Controllers\ManagerDashboard;

use App\Http\Controllers\Controller;
use App\Models\MaintenanceSchedule;
use Illuminate\Http\Request;

class MaintenanceTaskController extends Controller
{
    //Manager Maintenance Tasks view
    public function maintenanceTaskView(Request $request)
    {
        // Get the search keyword from the request
        $search = $request->input('search_schedule');

        // Fetch maintenance schedules with filtering based on the search keyword
        $schedules = MaintenanceSchedule::with(['vehicle.customer'])
            ->where('isAppointed', true)
            ->when($search, function ($query, $search) {
                $query->whereHas('vehicle', function ($q) use ($search) {
                    $q->where('make', 'like', "%{$search}%")
                        ->orWhere('model', 'like', "%{$search}%")
                        ->orWhere('year_of_manufacture', 'like', "%{$search}%")
                        ->orWhereHas('customer', function ($c) use ($search) {
                            $c->where('fullname', 'like', "%{$search}%");
                        });
                })
                ->orWhere('maintenance_type', 'like', "%{$search}%");
            })
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
            ->get();

        return view('pages.manager_pages.manager_maintenance_tasks', ['schedules' => $schedules]);
    }

    public function filterByDateRange(Request $request)
    {
        // Validate that the start_date and end_date are provided and valid
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        // Retrieve the start and end dates from the request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Query to filter maintenance schedules within the date range
        $schedules = MaintenanceSchedule::with(['vehicle.customer'])
            ->where('isAppointed', true)
            ->whereBetween('scheduled_date', [$startDate, $endDate])
            ->orderBy('scheduled_date', 'ASC')
            ->get();

        return view('pages.manager_pages.manager_maintenance_tasks', ['schedules' => $schedules]);
    }

}
