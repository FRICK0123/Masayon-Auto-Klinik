<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Customer;
use App\Models\MaintenanceHistory;
use App\Models\MaintenanceSchedule;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserManagementController extends Controller
{
    public function usersView(Request $request)
    {
        // Get the filter from the request
        $filter = $request->input('filter_users');

        // Base query
        $query = Customer::where('usertype', 'customer');

        // Count users online within the last 3 minutes
        $onlineCount = Customer::where('usertype', 'customer')
        ->where('last_seen', '>=', Carbon::now()->subMinutes(3))  // Active in the last 3 minutes
        ->where('last_seen', '<=', Carbon::now())  // Ensuring it's not a future time
        ->count();

        $customerCount = $query->count();

        // Apply filter
        if ($filter == 'by_fullname') {
            $query->orderBy('fullname', 'asc');
        } elseif ($filter == 'by_username') {
            $query->orderBy('username', 'asc');
        } elseif ($filter == 'by_creation') {
            $query->orderBy('created_at', 'desc');
        }

        if($request->has('search_customers') && $request->input('search_customers') !== ''){
            $searchTerm = $request->input('search_customers');

            $query = Customer::where('fullname', 'LIKE', "%{$searchTerm}%")->where('usertype', 'customer')->orWhere('username', 'LIKE', "%{$searchTerm}%")->where('usertype', 'customer')->orWhere('email', 'LIKE', "%{$searchTerm}%")->where('usertype','customer');
        }

        // Paginate with filter parameters
        $customer = $query->paginate(10)->appends($request->except('page'));

        // Pass the filtered/ordered customers to the view
        return view('pages.admin_pages.admin_user_management',
         [
            'users' => $customer,
            'customerCount'=>$customerCount,
            'onlineCount'=>$onlineCount,
        ]);
    }

    // Add User to the database
    public function storeUser(Request $request)
    {
        // Check if a file is uploaded
        if ($request->hasFile('profile_image')) {
            // Get the uploaded file
            $file = $request->file('profile_image');

            // Define the upload path
            $uploadPath = 'Images/profile_images/';

            // Generate a unique name for the image
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            // Move the file to the specified folder
            $file->move(public_path($uploadPath), $fileName);

            // Set the profile image to the uploaded file name
            $profile_image = $fileName;
        } else {
            // Set a default profile image if no file is uploaded
            $profile_image = "default_user.png";
        }

        $validate = $request->validate(
            [
                'register_username' => 'unique:customers,username',
                'register_email' => 'unique:customers,email'
            ],
            [
                'register_username.unique' => 'Username is already taken',
                'register_email.unique' => 'The email address is already registered.',
            ]
        );

        // Create the new customer in the database
        Customer::create([
            'fullname' => $request->input('register_fullname'),
            'email' => $request->input('register_email'),
            'phone_number' => $request->input('register_phone'),
            'username' => $request->input('register_username'),
            'password' => Hash::make($request->input('register_password')),
            'profile_img' => $profile_image, // Use the default or uploaded image
            'email_verified_at' => now(),
            'verification_token' => null,
            'isVerified' => true,
            'isDeactivated' => false,
            'usertype' => 'customer',
            'last_seen' => Carbon::now(),
        ]);
        session()->flash('customer_added', $request->input('register_fullname') . " Successfully Registered!");

        // Redirect to the users view page
        return to_route('users_view');
    }

    //View Users page
    public function viewUserInfo($customerID){
        $customer = Customer::where('customerID',$customerID)->first();
        $vehicles = Vehicle::where('customerID', $customerID)->get();
        $previous_maintenance = MaintenanceHistory::where('customerID', $customerID)->orderBy('date_performed','desc')->get();
        return view('pages.admin_pages.admin_users.admin_view_user',['customer' => $customer,'vehicles'=>$vehicles,'previous_maintenance'=> $previous_maintenance]);
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
            'isDeactivated' => false,
        ]);
        
        // Set a session flash message
        session()->flash('vehicle_added', "$car_make $car_model $year_of_manufacture Successfully Added!");
        $vehicles = Vehicle::where('customerID', $customerID)->get();
        $customer = Customer::where('customerID', $customerID)->first();
        return view('pages.admin_pages.admin_users.admin_view_user_vehicles', ['vehicles' => $vehicles, 'customer' => $customer]);
    }

    //Add Specific Vehicle Maintenance Schedule
    public function addUserVehicleMaintenanceScheduleView($vehicleID){
        $vehicle = Vehicle::where('vehicleID', $vehicleID)->first();
        return view('pages.admin_pages.admin_users.admin_add_user_vehicle_maintenance_schedule', ['vehicle' => $vehicle]);
    }

    //Maintenance Schedule Form Submittion
    public function scheduleMaintenance(Request $request)
    {
        $vehicleID = $request->input('vehicleID');
        $customerID = $request->input('customerID');
        $maintenance_type = $request->input('maintenance_type');
        $maintenance_date = $request->input('maintenance_date');
        $scheduled_interval = $request->input('scheduled_interval');
        $last_maintenance_date = $request->input('maintenance_date');
        $oil_type = $request->input('oil_type');
        $milage = $request->input('milage');
        $milage_interval = $request->input('mileage_interval');
        $basic_pms = $request->input('basic', []);
        $basic_services = implode(',', $basic_pms);
        $full_pms = $request->input('full', []);
        $full_pms_services = implode(',', $full_pms);

        // Check for existing maintenance type for this vehicle
        $existingSchedule = MaintenanceSchedule::where('vehicleID', $vehicleID)
        ->where('maintenance_type', $maintenance_type)
        ->where('isDeactivated', false) // Consider only active schedules
        ->first();

        if ($existingSchedule) {
            return back()->withErrors(['maintenance_type' => 'This maintenance type already exists for the selected vehicle.']);
        }

        $appointmentDate = Carbon::parse($maintenance_date);

        $appointmentDateCount = MaintenanceSchedule::whereDate('appointment_date', $appointmentDate->toDateString())->count();
        if ($appointmentDateCount >= 3) {
            return back()->withErrors(['appointment_date' => 'The appointment limit for this day has been reached.']);
        } else {
            if ($maintenance_type == "Oil Change") {
                MaintenanceSchedule::create([
                    'vehicleID' => $vehicleID,
                    'customerID' => $customerID,
                    'maintenance_type' => $maintenance_type,
                    'PMS_services' => null,
                    'scheduled_date' => $last_maintenance_date,
                    'last_maintenance_date' => $last_maintenance_date,
                    'scheduled_interval' => $scheduled_interval,
                    'oil_type' => $oil_type,
                    'current_milage' => $milage,
                    'next_milage_schedule' => $milage,
                    'isAppointed' => false,
                    'appointment_date' => $maintenance_date,
                    'isDeactivated' => false,
                    'isRegarded' => false,
                ]);
            } else if ($maintenance_type == "EGR Cleaning") {
                MaintenanceSchedule::create([
                    'vehicleID' => $vehicleID,
                    'customerID' => $customerID,
                    'maintenance_type' => $maintenance_type,
                    'PMS_services' => null,
                    'scheduled_date' => $last_maintenance_date,
                    'last_maintenance_date' => $last_maintenance_date,
                    'scheduled_interval' => 48,
                    'oil_type' => null,
                    'current_milage' => $milage,
                    'next_milage_schedule' => $milage,
                    'isAppointed' => false,
                    'appointment_date' => $maintenance_date,
                    'isDeactivated' => false,
                    'isRegarded' => false,
                ]);
            } else if ($maintenance_type == "Basic PMS") {
                MaintenanceSchedule::create([
                    'vehicleID' => $vehicleID,
                    'customerID' => $customerID,
                    'maintenance_type' => $maintenance_type,
                    'PMS_services' => $basic_services,
                    'scheduled_date' => $last_maintenance_date,
                    'last_maintenance_date' => $last_maintenance_date,
                    'scheduled_interval' => $scheduled_interval,
                    'oil_type' => null,
                    'current_milage' => $milage,
                    'next_milage_schedule' => $milage,
                    'isAppointed' => false,
                    'appointment_date' => $maintenance_date,
                    'isDeactivated' => false,
                    'isRegarded' => false,
                ]);
            } else if ($maintenance_type == "Full PMS") {
                MaintenanceSchedule::create([
                    'vehicleID' => $vehicleID,
                    'customerID' => $customerID,
                    'maintenance_type' => $maintenance_type,
                    'PMS_services' => $full_pms_services,
                    'scheduled_date' => $last_maintenance_date,
                    'last_maintenance_date' => $last_maintenance_date,
                    'scheduled_interval' => $scheduled_interval,
                    'oil_type' => null,
                    'current_milage' => $milage,
                    'next_milage_schedule' => $milage,
                    'isAppointed' => false,
                    'appointment_date' => $maintenance_date,
                    'isDeactivated' => false,
                    'isRegarded' => false,
                ]);
            } else if($maintenance_type == "other"){
                MaintenanceSchedule::create([
                    'vehicleID' => $vehicleID,
                    'customerID' => $customerID,
                    'maintenance_type' => $request->input('other'),
                    'PMS_services' => null,
                    'scheduled_date' => $last_maintenance_date,
                    'last_maintenance_date' => $last_maintenance_date,
                    'scheduled_interval' => $scheduled_interval,
                    'oil_type' => null,
                    'current_milage' => null,
                    'next_milage_schedule' => null,
                    'isAppointed' => false,
                    'appointment_date' => $maintenance_date,
                    'isDeactivated' => false,
                    'isRegarded' => false,
                ]);
            }else {
                MaintenanceSchedule::create([
                    'vehicleID' => $vehicleID,
                    'customerID' => $customerID,
                    'maintenance_type' => $maintenance_type,
                    'PMS_services' => null,
                    'scheduled_date' => $last_maintenance_date,
                    'last_maintenance_date' => $last_maintenance_date,
                    'scheduled_interval' => $scheduled_interval,
                    'oil_type' => null,
                    'current_milage' => null,
                    'next_milage_schedule' => null,
                    'isAppointed' => false,
                    'appointment_date' => $maintenance_date,
                    'isDeactivated' => false,
                    'isRegarded' => false,
                ]);
            }

            session()->flash('schedule',"Maintenance Schedule Added");

            return to_route('admin_appointment_view');
        }
    }

    //Vehicle Maintenance Walk In View
    public function walkinMaintenanceView($vehicleID){
        $vehicle = Vehicle::where('vehicleID', $vehicleID)->first();
        return view('pages.admin_pages.admin_walkin_maintenance', ['vehicle' => $vehicle]);
    }

    //Walk in Maintenance Schedule Form Submittion
    public function walkinMaintenance(Request $request)
    {
        $vehicleID = $request->input('vehicleID');
        $customerID = $request->input('customerID');
        $maintenance_type = $request->input('maintenance_type');
        $maintenance_date = $request->input('maintenance_date');
        $scheduled_interval = $request->input('scheduled_interval');
        $last_maintenance_date = $request->input('maintenance_date');
        $oil_type = $request->input('oil_type');
        $milage = $request->input('milage');
        $milage_interval = $request->input('mileage_interval');
        $basic_pms = $request->input('basic', []);
        $basic_services = implode(',', $basic_pms);
        $full_pms = $request->input('full', []);
        $full_pms_services = implode(',', $full_pms);

        // Check for existing maintenance type for this vehicle
        $existingSchedule = MaintenanceSchedule::where('vehicleID', $vehicleID)
        ->where('maintenance_type', $maintenance_type)
        ->where('isDeactivated', false) // Consider only active schedules
        ->first();

        if ($existingSchedule) {
            return back()->withErrors(['maintenance_type' => 'This maintenance type already exists for the selected vehicle.']);
        }

        $appointmentDate = Carbon::parse($maintenance_date);

        $appointmentDateCount = MaintenanceSchedule::whereDate('appointment_date', $appointmentDate->toDateString())->count();
        if ($appointmentDateCount >= 3) {
            return back()->withErrors(['appointment_date' => 'The appointment limit for this day has been reached.']);
        } else {
            if ($maintenance_type == "Oil Change") {
                MaintenanceSchedule::create([
                    'vehicleID' => $vehicleID,
                    'customerID' => $customerID,
                    'maintenance_type' => $maintenance_type,
                    'PMS_services' => null,
                    'scheduled_date' => Carbon::parse($maintenance_date),
                    'last_maintenance_date' => $last_maintenance_date,
                    'scheduled_interval' => $scheduled_interval,
                    'oil_type' => $oil_type,
                    'current_milage' => $milage,
                    'next_milage_schedule' => $milage + $milage_interval,
                    'isAppointed' => true,
                    'appointment_date' => $maintenance_date,
                    'isDeactivated' => false,
                    'isRegarded' => false,
                ]);
            } else if ($maintenance_type == "EGR Cleaning") {
                MaintenanceSchedule::create([
                    'vehicleID' => $vehicleID,
                    'customerID' => $customerID,
                    'maintenance_type' => $maintenance_type,
                    'PMS_services' => null,
                    'scheduled_date' => Carbon::parse($maintenance_date),
                    'last_maintenance_date' => $last_maintenance_date,
                    'scheduled_interval' => 48,
                    'oil_type' => null,
                    'current_milage' => $milage,
                    'next_milage_schedule' => $milage + 50000,
                    'isAppointed' => true,
                    'appointment_date' => $maintenance_date,
                    'isDeactivated' => false,
                    'isRegarded' => false,
                ]);
            } else if ($maintenance_type == "Basic PMS") {
                MaintenanceSchedule::create([
                    'vehicleID' => $vehicleID,
                    'customerID' => $customerID,
                    'maintenance_type' => $maintenance_type,
                    'PMS_services' => $basic_services,
                    'scheduled_date' => Carbon::parse($maintenance_date),
                    'last_maintenance_date' => $last_maintenance_date,
                    'scheduled_interval' => $scheduled_interval,
                    'oil_type' => null,
                    'current_milage' => $milage,
                    'next_milage_schedule' => $milage + 5000,
                    'isAppointed' => true,
                    'appointment_date' => $maintenance_date,
                    'isDeactivated' => false,
                    'isRegarded' => false,
                ]);
            } else if ($maintenance_type == "Full PMS") {
                MaintenanceSchedule::create([
                    'vehicleID' => $vehicleID,
                    'customerID' => $customerID,
                    'maintenance_type' => $maintenance_type,
                    'PMS_services' => $full_pms_services,
                    'scheduled_date' => Carbon::parse($maintenance_date),
                    'last_maintenance_date' => $last_maintenance_date,
                    'scheduled_interval' => $scheduled_interval,
                    'oil_type' => null,
                    'current_milage' => $milage,
                    'next_milage_schedule' => $milage + 50000,
                    'isAppointed' => true,
                    'appointment_date' => $maintenance_date,
                    'isDeactivated' => false,
                    'isRegarded' => false,
                ]);
            } else if($maintenance_type == "other"){
                MaintenanceSchedule::create([
                    'vehicleID' => $vehicleID,
                    'customerID' => $customerID,
                    'maintenance_type' => $request->input('other'),
                    'PMS_services' => null,
                    'scheduled_date' => Carbon::parse($maintenance_date),
                    'last_maintenance_date' => $last_maintenance_date,
                    'scheduled_interval' => $scheduled_interval,
                    'oil_type' => null,
                    'current_milage' => null,
                    'next_milage_schedule' => null,
                    'isAppointed' => true,
                    'appointment_date' => $maintenance_date,
                    'isDeactivated' => false,
                    'isRegarded' => false,
                ]);
            } else {
                MaintenanceSchedule::create([
                    'vehicleID' => $vehicleID,
                    'customerID' => $customerID,
                    'maintenance_type' => $maintenance_type,
                    'PMS_services' => null,
                    'scheduled_date' => Carbon::parse($maintenance_date),
                    'last_maintenance_date' => $last_maintenance_date,
                    'scheduled_interval' => $scheduled_interval,
                    'oil_type' => null,
                    'current_milage' => null,
                    'next_milage_schedule' => null,
                    'isAppointed' => true,
                    'appointment_date' => $maintenance_date,
                    'isDeactivated' => false,
                    'isRegarded' => false,
                ]);
            }
            session()->flash('appointment',"Maintenance Task Added");
            return to_route('maintenance_status_view');
        }
    }

    //Edit User Info View
    public function editUserInfoView($customerID){
        $customerInfo = Customer::where('customerID',$customerID)->first();
        return view('pages.admin_pages.admin_users.admin_edit_user', ['customer' => $customerInfo]);
    }

    //Change Customer Account Password
    public function changePassword(Request $request, $customerID){
        $newPassword = Hash::make($request->input('new_password'));

        Customer::where('customerID',$customerID)->update(['password'=>$newPassword]);
        session()->flash('password_changed', "Password Successfully Changed");
        return to_route('users_view');
    }

    //Edit User Info
    public function editUserInfo(Request $request, $customerID){
        $fullname = $request->input('fullname');
        $email_address = $request->input('email_address');
        $phone_number = $request->input('phone_number');
        $username = $request->input('username');

        Customer::where('customerID', $customerID)->update([
            'fullname' => $fullname,
            'email' => $email_address,
            'phone_number' => $phone_number,
            'username' => $username,
        ]);
        session()->flash('details_edited', "Customer Details Successfully Updated");
        return to_route('users_view');
    }

    //View User Maintenance Schedule
    public function viewUserMaintenance($customerID){
        // // Fetch maintenance schedules and join with vehicles and customers
        $schedules = MaintenanceSchedule::whereHas('vehicle', function ($query) use ($customerID) {
            $query->where('customerID', $customerID);
        })
            ->with(['vehicle.customer'])
            ->where('isAppointed', true)

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

        return view('pages.admin_pages.admin_users.admin_view_customer_schedules', ['schedules' => $schedules]);
    }

    //Deactivate Customer Account
    public function deactivateCustomer($customerID){
        Customer::where('customerID',$customerID)->update([
            'isDeactivated' => true
        ]);

        Vehicle::where('customerID', $customerID)->update([
            'isDeactivated' => true
        ]);

        MaintenanceSchedule::where('customerID', $customerID)->update([
            'isDeactivated' => true
        ]);
        session()->flash('deactivate',"Customer Successfully Deactivated");

        return to_route('users_view');
    }

    //activate Customer Account
    public function activateCustomer($customerID)
    {
        Customer::where('customerID', $customerID)->update([
            'isDeactivated' => false
        ]);

        Vehicle::where('customerID', $customerID)->update([
            'isDeactivated' => false
        ]);

        MaintenanceSchedule::where('customerID', $customerID)->update([
            'isDeactivated' => false
        ]);

        session()->flash('activate', "Customer Successfully Activated");
        return to_route('users_view');
    }

    // Delete User Account
    public function deleteUser($customerID)
    {
        // Find the customer
        $customer = Customer::where('customerID', $customerID)->first();

        if ($customer) {
            // Delete associated vehicles
            Vehicle::where('customerID', $customerID)->delete();

            // Delete associated maintenance schedules
            MaintenanceSchedule::where('customerID', $customerID)->delete();

            // Delete the customer
            $customer->delete();
        }

        session()->flash('customer_deleted',"Customer Successfully Deleted!");

        return to_route('users_view');
    }

    public function deleteVehicle($vehicleID){
        $vehicle = Vehicle::where('vehicleID', $vehicleID)->first();
        $make = $vehicle['make'];
        $model = $vehicle['model'];
        $year_of_manufacture = $vehicle['year_of_manufacture'];

        if ($vehicle) {
            // Delete related maintenance schedules for this vehicle
            MaintenanceSchedule::where('vehicleID', $vehicleID)->delete();

            // Delete only the specific vehicle
            $vehicle->delete();

            session()->flash('vehicle_deleted', "$make $model $year_of_manufacture Successfully Deleted!");
        }

        return to_route('users_view');
    }

    public function unverifyCustomer($customerID){
        $customer = Customer::where('customerID', $customerID)->update(['isVerified'=>false]);

        session()->flash('unverify',"Customer Successfully Unverified");
        return to_route('users_view');
    }

    public function verifyCustomer($customerID)
    {
        $customer = Customer::where('customerID', $customerID)->update(['isVerified' => true]);

        session()->flash('verify', "Customer Successfully Verified");
        return to_route('users_view');
    }
}
