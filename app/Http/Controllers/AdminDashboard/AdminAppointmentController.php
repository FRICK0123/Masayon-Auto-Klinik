<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Http\Controllers\Controller;
use App\Models\MaintenanceSchedule;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminAppointmentController extends Controller
{
    //Admin Appointment Controller View
    public function adminAppointmentView(Request $request){
        // Start the base query for fetching maintenance schedules joined with vehicles
        $query = MaintenanceSchedule::join('vehicles', 'maintenance_schedules.vehicleID', '=', 'vehicles.vehicleID')
            ->join('customers', 'vehicles.customerID', '=', 'customers.customerID')
            ->where('maintenance_schedules.isAppointed', false)
            ->select('maintenance_schedules.*', 'vehicles.*', 'customers.fullname as customer_name');

        // Check if there is a search term and filter the results
        if ($request->has('search_appointment') && $request->input('search_appointment') !== '') {
            $searchTerm = $request->input('search_appointment');

            // Add where clauses to search for the term in multiple columns
            $query->where(function ($query) use ($searchTerm) {
                $query->where('vehicles.make', 'LIKE', "%$searchTerm%")
                    ->orWhere('vehicles.model', 'LIKE', "%$searchTerm%")
                    ->orWhere('vehicles.plate_number', 'LIKE', "%$searchTerm%")
                    ->orWhere('vehicles.year_of_manufacture', 'LIKE', "%$searchTerm%")
                    ->orWhere('maintenance_schedules.maintenance_type', 'LIKE', "%$searchTerm%")
                    ->orWhere('customers.fullname', 'LIKE', "%$searchTerm%");
            });
        }

        // Execute the query to get the results
        $schedules = $query->get();

        return view('pages.admin_pages.admin_appointment', [
            'schedules' => $schedules,
        ]);
    }

    public function appointmentsByDateRange(Request $request)
    {
        // Parse and validate the dates
        $startDate = Carbon::parse($request->input('start_date'))->startOfDay();
        $endDate = Carbon::parse($request->input('end_date'))->endOfDay();

        // Fetch schedules based on the date range
        $schedules = MaintenanceSchedule::join('vehicles', 'maintenance_schedules.vehicleID', '=', 'vehicles.vehicleID')
        ->join('customers', 'vehicles.customerID', '=', 'customers.customerID')
        ->whereBetween('maintenance_schedules.appointment_date', [$startDate, $endDate])
            ->where('maintenance_schedules.isAppointed', false)
            ->select('maintenance_schedules.*', 'vehicles.*', 'customers.fullname as customer_name')
            ->get();

        return view('pages.admin_pages.admin_appointment', [
            'schedules' => $schedules,
        ]);
    }
}
