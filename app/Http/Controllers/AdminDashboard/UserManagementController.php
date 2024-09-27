<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Customer;
use App\Models\MaintenanceSchedule;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserManagementController extends Controller
{
    //User Management Page View
    public function usersView(){
        $customer = Customer::where('usertype','customer')->orderBy('fullname','asc')->get();
        return view('pages.admin_pages.admin_user_management',["users"=>$customer]);
    }

    //Add User to the database
    public function storeUser(Request $request){
        if ($request->hasFile('profile_image')) {
            // Get the uploaded file
            $file = $request->file('profile_image');

            // Define the upload path
            $uploadPath = 'Images/profile_images/';

            // Generate a unique name for the image
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            // Move the file to the specified folder
            $file->move(public_path($uploadPath), $fileName);

            $profile_image = $fileName;
        } else {
            $profile_image = 'default_user.png';
        }

        Customer::create([
            'fullname' => $request->input('register_fullname'),
            'email' => $request->input('register_email'),
            'phone_number' => $request->input('register_phone'),
            'username' => $request->input('register_username'),
            'password' => Hash::make($request->input('register_password')),
            'profile_img' => $profile_image,
            'email_verified_at' => now(),
            'verification_token' => null,
            'isVerified' => true,
            'usertype' => 'customer',
        ]);

        return to_route('users_view');
    }

    //Users Filter
    public function userFilter(Request $request)
    {
        $filter_value = $request->input('filter_users');

        if ($filter_value == "by_fullname") {
            $user=Customer::orderBy('fullname', 'asc')->get();
        } elseif ($filter_value == "by_username") {
            $user = Customer::orderBy('username', 'asc')->get();
        } elseif ($filter_value == "by_creation") {
            $user = Customer::orderBy('created_at', 'desc')->get();
        }

        return view('pages.admin_pages.admin_user_management', ["users" => $user]);
    }

    //View Users page
    public function viewUserInfo($customerID){
        $customer = Customer::where('customerID',$customerID)->first();
        return view('pages.admin_pages.admin_users.admin_view_user',['customer' => $customer]);
    }

    //View User's vehicle
    public function viewUserVehicleInfo($customerID){
        $vehicles = Vehicle::where('customerID',$customerID)->get();
        $customer = Customer::where('customerID', $customerID)->first();
        return view('pages.admin_pages.admin_users.admin_view_user_vehicles',['vehicles' => $vehicles, 'customer' => $customer]);
    }

    //Add Vehicle of User page view
    public function addVehicleView($customerID){
        $cars = Car::orderBy('car_make', 'asc')->get();
        return view('pages.admin_pages.admin_users.admin_add_user_vehicle',[
            'cars' => $cars,
            'customerID' => $customerID,
        ]);
    }

    //Add Car
    public function addUserVehicle($customerID, Request $request)
    {
        $validated = $request->validate([
            'year_of_manufacture' => 'required|integer|between:1900,' . date('Y'),
        ]);
        $car_make = $request->input('car_make');
        $car_model = $request->input('car_model');
        $year_of_manufacture = $request->input('year_of_manufacture');
        $milage = $request->input('milage');
        $engine_number = $request->input('engine_number');
        $vehicle_identification_number = $request->input('vehicle_identification_number');
        $chassis_number = $request->input('chassis_number');
        $plate_number = $request->input('plate_number');
        $engine_type = $request->input('engine_type');

        if ($request->hasFile('car_image')) {
            // Get the uploaded file
            $file = $request->file('car_image');

            // Define the upload path
            $uploadPath = 'Images/car_images/';

            // Generate a unique name for the image
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            // Move the file to the specified folder
            $file->move(public_path($uploadPath), $fileName);

            $car_image = $fileName;
        } else {
            $car_image = $request->input('car_image_hidden');
        }

        Vehicle::create([
            'customerID' => $customerID,
            'make' => $car_make,
            'model' => $car_model,
            'year_of_manufacture' => $year_of_manufacture,
            'vehicle_image' => $car_image,
            'milage' => $milage,
            'engine_number' => $engine_number,
            'vehicle_identification_number' => $vehicle_identification_number,
            'chassis_number' => $chassis_number,
            'engine_type' => $engine_type,
            'plate_number' => $plate_number,
        ]);

        $vehicles = Vehicle::where('customerID', $customerID)->get();
        $customer = Customer::where('customerID', $customerID)->first();
        return view('pages.admin_pages.admin_users.admin_view_user_vehicles', ['vehicles' => $vehicles, 'customer' => $customer]);
    }

    //Add Specific Vehicle Maintenance Schedule
    public function addUserVehicleMaintenanceScheduleView($vehicleID){
        $vehicle = Vehicle::where('vehicleID', $vehicleID)->first();
        return view('pages.admin_pages.admin_users.admin_add_user_vehicle_maintenance_schedule', ['vehicle' => $vehicle]);
    }

    //Admin Maintenance Schedule Form Submittion
    public function storeMaintenanceSchedule(Request $request)
    {
        $vehicleID = $request->input('vehicleID');
        $maintenance_type = $request->input('maintenance_type');
        $maintenance_date = $request->input('maintenance_date');
        $scheduled_interval = $request->input('scheduled_interval');
        $last_maintenance_date = $request->input('maintenance_date');
        $oil_type = $request->input('oil_type');
        $milage = $request->input('milage');
        $milage_interval = $request->input('mileage_interval');

        if ($maintenance_type == "Oil Change") {
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
        } else if ($maintenance_type == "EGR Cleaning") {
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
        } else if ($maintenance_type == "Basic PMS") {
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

        return to_route('maintenance_overview');
    }
}
