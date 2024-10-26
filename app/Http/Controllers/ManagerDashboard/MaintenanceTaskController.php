<?php

namespace App\Http\Controllers\ManagerDashboard;

use App\Http\Controllers\Controller;
use App\Models\MaintenanceSchedule;
use Illuminate\Http\Request;

class MaintenanceTaskController extends Controller
{
    //Manager Maintenance Tasks view
    public function maintenanceTaskView(){
        //Fetch maintenance schedules and join with vehicles and customers
        $schedules = MaintenanceSchedule::with(['vehicle.customer'])->where('isAppointed', true)

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
}
