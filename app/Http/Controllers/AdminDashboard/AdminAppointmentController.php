<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\MaintenanceSchedule;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use GuzzleHttp\Client as GuzzleHttpClient;

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

    //Confirm Appointment
    public function confirmAppointment(Request $request){
        $maintenanceID = $request->input('maintenance_id');
        $maintenance_schedule = MaintenanceSchedule::where('maintenanceID', $maintenanceID)->first();
        $cost = $request->input('cost');

        MaintenanceSchedule::where('maintenanceID',$maintenanceID)->update([
            'isAppointed' => true,
        ]);

        $customerID = $request->input('customer_id');
        $vehicleID = $request->input('vehicle_id');
        $owner = $request->input('owner');
        $vehicle = $request->input('vehicle');
        $maintenance_type = $request->input('maintenance_type');
        $scheduled_date = $maintenance_schedule['scheduled_date'];
        $scheduled_date_orig = $request->input('scheduled_date_orig');
        $content = "Good Day Sir/Ma'am " . $owner . ", we would like to inform you that your " . $vehicle . " is due for " . $maintenance_type . " on " . $scheduled_date . ". Please prepare an exact amount of ₱" . $cost . " for the service.";

        $customer = Customer::where('customerID', $customerID)->first();
        $customerNum = "+63" . $customer['phone_number'];

        // //Send SMS notification
        $client = new GuzzleHttpClient();
        $apiKey = "6txNEfdDAqAZSHw1PF18iWG0GkWHtGeBW_sAX9z8PEUS59HU3zuZAgd_h8wiLuv6";

        $res = $client->request('POST', 'https://api.httpsms.com/v1/messages/send', [
            'headers' => [
                'x-api-key' => $apiKey,
            ],
            'json'    => [
                'content' => "From Masayon Auto Klinik: \nGood Day Sir/Ma'am " . $owner . ", we would like to inform you that your " . $vehicle . " is due for " . $maintenance_type . " on " . $scheduled_date . ". Please prepare an exact amount of ₱". $cost . " for the service.",
                'from'    => "+639999129152",
                'to'      => $customerNum
            ]
        ]);

        Notification::create([
            'customerID' => $customerID,
            'vehicleID' => $vehicleID,
            'maintenanceID' => $maintenanceID,
            'owner' => $owner,
            'vehicle' => $vehicle,
            'maintenance_type' => $maintenance_type,
            'scheduled_date' => $scheduled_date,
            'content' => $content,
            'isConfirmed' => false,
        ]);

        return to_route('maintenance_status_view');
    }

    //Cancel Appointment
    public function cancelAppointment($maintenanceID)
    {
        $schedule = MaintenanceSchedule::where('maintenanceID', $maintenanceID)->first();
        $schedule->delete();

        return to_route('admin_appointment_view')->with('cancelled', 'Appointment Successfully Removed');
    }
}
