<?php

namespace App\Http\Controllers\ManagerDashboard;

use App\Http\Controllers\Controller;
use App\Models\MaintenanceHistory;
use App\Models\MaintenanceSchedule;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ManagerAppointmentController extends Controller
{
    //Appointments view
    public function appointmentView(Request $request){
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
        return view('pages.manager_pages.manager_appointments',['schedules'=>$schedules]);
    }

    //Maintenance Status Update
    public function managerAppointmentUpdate(Request $request)
    {
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

        $maintenance_schedule = MaintenanceSchedule::where('maintenanceID', $maintenanceID)->first();

        if (($maintenance_type == "Oil Change" && $oil_type == "Mobil Delvac I 5W-40 Fully Synthetic Diesel Oil") || ($maintenance_type == "Oil Change" && $oil_type == "Mobil Super 5W-30 Fully Synthetic Gasoline Oil")) {
            Vehicle::where('vehicleID', $vehicleID)->update(['milage' => $current_milage]);
            $maintenance = DB::table('maintenance_schedules')->where('maintenanceID', $maintenanceID)->first();
            MaintenanceSchedule::where('maintenanceID', $maintenanceID)->update([
                'scheduled_date' => Carbon::today()->addMonths($maintenance->scheduled_interval),
                'last_maintenance_date' => Carbon::today(),
                'current_milage' => $current_milage,
                'next_milage_schedule' => $current_milage + 8000,
                'isAppointed' => true,
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

            session()->flash('schedule_updated' , "Maintenance/Repair for $vehicle completed");

            return to_route('manager_appointment');
        } else if (($maintenance_type == "Oil Change" && $oil_type == "Mobil Delvac 15W-40 Semi Synthetic Diesel Oil") || ($maintenance_type == "Oil Change" && $oil_type == "Mobil Special 20w-50 Ordinary Gasoline Oil")) {
            Vehicle::where('vehicleID', $vehicleID)->update(['milage' => $current_milage]);
            $maintenance = DB::table('maintenance_schedules')->where('maintenanceID', $maintenanceID)->first();
            MaintenanceSchedule::where('maintenanceID', $maintenanceID)->update([
                'scheduled_date' => Carbon::today()->addMonths($maintenance->scheduled_interval),
                'last_maintenance_date' => Carbon::today(),
                'current_milage' => $current_milage,
                'next_milage_schedule' => $current_milage + 5000,
                'isAppointed' => true,
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
            session()->flash('schedule_updated', "Maintenance/Repair for $vehicle completed");

            return to_route('manager_appointment');

        } else if ($maintenance_type == "EGR Cleaning") {
            Vehicle::where('vehicleID', $vehicleID)->update(['milage' => $current_milage]);
            $maintenance = DB::table('maintenance_schedules')->where('maintenanceID', $maintenanceID)->first();
            MaintenanceSchedule::where('maintenanceID', $maintenanceID)->update([
                'scheduled_date' => Carbon::today()->addMonths($maintenance->scheduled_interval),
                'last_maintenance_date' => Carbon::today(),
                'current_milage' => $current_milage,
                'next_milage_schedule' => $current_milage + 50000,
                'isAppointed' => true,
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
            session()->flash('schedule_updated', "Maintenance/Repair for $vehicle completed");

            return to_route('manager_appointment');

        } else if ($maintenance_type == "Basic PMS") {
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
                    ]);
                } else if (($oil_maintenance['oil_type'] == "Mobil Delvac 15W-40 Semi Synthetic Diesel Oil") || ($oil_maintenance['oil_type'] == "Mobil Special 20w-50 Ordinary Gasoline Oil")) {
                    $maintenanceOil = MaintenanceSchedule::where('vehicleID', $vehicleID)->where('maintenance_type', "Oil Change")->first();
                    MaintenanceSchedule::where('maintenanceID', $maintenanceOil->maintenanceID)->update([
                        'scheduled_date' => Carbon::today()->addMonths($maintenanceOil->scheduled_interval),
                        'last_maintenance_date' => Carbon::today(),
                        'current_milage' => $current_milage,
                        'next_milage_schedule' => $current_milage + 5000,
                        'isAppointed' => true,
                    ]);
                }
            }

            $brakes_maintenance = MaintenanceSchedule::where('vehicleID', $vehicleID)->where('maintenance_type', "Check Brake")->first();
            if ($brakes_maintenance) {
                MaintenanceSchedule::where('maintenanceID', $brakes_maintenance->maintenanceID)->update([
                    'scheduled_date' => Carbon::today()->addMonths($brakes_maintenance->scheduled_interval),
                    'last_maintenance_date' => Carbon::today(),
                    'current_milage' => $current_milage,
                    'isAppointed' => true,
                ]);
            }

            $concerns_maintenance = MaintenanceSchedule::where('vehicleID', $vehicleID)->where('maintenance_type', "Check Concerns")->first();
            if ($concerns_maintenance) {
                MaintenanceSchedule::where('maintenanceID', $concerns_maintenance->maintenanceID)->update([
                    'scheduled_date' => Carbon::today()->addMonths($concerns_maintenance->scheduled_interval),
                    'last_maintenance_date' => Carbon::today(),
                    'current_milage' => $current_milage,
                    'isAppointed' => true,
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
            session()->flash('schedule_updated', "Maintenance/Repair for $vehicle completed");

            return to_route('manager_appointment');
        } else if ($maintenance_type == "Heavy PMS") {
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
                    ]);
                } else if (($oil_maintenance['oil_type'] == "Mobil Delvac 15W-40 Semi Synthetic Diesel Oil") || ($oil_maintenance['oil_type'] == "Mobil Special 20w-50 Ordinary Gasoline Oil")) {
                    $maintenanceOil = MaintenanceSchedule::where('vehicleID', $vehicleID)->where('maintenance_type', "Oil Change")->first();
                    MaintenanceSchedule::where('maintenanceID', $maintenanceOil->maintenanceID)->update([
                        'scheduled_date' => Carbon::today()->addMonths($maintenanceOil->scheduled_interval),
                        'last_maintenance_date' => Carbon::today(),
                        'current_milage' => $current_milage,
                        'next_milage_schedule' => $current_milage + 5000,
                        'isAppointed' => true,
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
            session()->flash('schedule_updated', "Maintenance/Repair for $vehicle completed");

            return to_route('manager_appointment');
        } else {
            Vehicle::where('vehicleID', $vehicleID)->update(['milage' => $current_milage]);
            $maintenance = DB::table('maintenance_schedules')->where('maintenanceID', $maintenanceID)->first();
            MaintenanceSchedule::where('maintenanceID', $maintenanceID)->update([
                'scheduled_date' => Carbon::today()->addMonths($maintenance->scheduled_interval),
                'last_maintenance_date' => Carbon::today(),
                'current_milage' => $current_milage,
                'isAppointed' => true,
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

            session()->flash('schedule_updated', "Maintenance/Repair for $vehicle completed");

            return to_route('manager_appointment');
        }
    }

    //Cancel Appointment
    public function cancelAppointment($maintenanceID){
        $schedule = MaintenanceSchedule::where('maintenanceID',$maintenanceID)->first();
        if ($schedule) {
            $schedule->delete();
            session()->flash('cancel', "Appointment Cancelled Successfully!");
        } else {
            session()->flash('error', "Appointment not found!");
        }

        return to_route('manager_appointment');
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

        return view('pages.manager_pages.manager_appointments', [
            'schedules' => $schedules,
        ]);
    }
}
