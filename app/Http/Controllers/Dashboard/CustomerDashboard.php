<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\MaintenanceHistory;
use App\Models\MaintenanceSchedule;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CustomerDashboard extends Controller
{
    //Dashboard View
    public function customerDashboardView(){
        $customerID = Auth::guard('customer')->id();
        $vehicles = Vehicle::where('customerID',$customerID)->get();
        return view('pages.customer_pages.customer_dashboard',['vehicles' => $vehicles]);
    }

    //Profile View
    public function customerProfileView(Request $request)
    {
        $customerID = Auth::guard('customer')->id();
        $vehicles = Vehicle::where('customerID', $customerID)->get();
        $query = MaintenanceHistory::where('customerID',Auth::guard('customer')->id());
        $transactions = $query->paginate(2)->appends($request->except('page'));
        return view('pages.customer_pages.customer_profile',['transactions'=>$transactions, 'vehicles' => $vehicles]);
    }

    //Maintenance Schedule View
    public function scheduleView()
    {
        $customerID = Auth::guard('customer')->id();

        $schedules = MaintenanceSchedule::join('vehicles', 'maintenance_schedules.vehicleID', '=', 'vehicles.vehicleID')
            ->where('vehicles.customerID', '=', $customerID) // Filter by the authenticated customer's ID
            ->where('maintenance_schedules.isAppointed', true)
            ->select('maintenance_schedules.*', 'vehicles.*')
            ->get();

        return view('pages.customer_pages.customer_schedule_maintenance', [
            'schedules' => $schedules,
        ]);
    }

    //Edit Customer Profile Details
    public function editCustomerDetails(Request $request){
        $fullname = $request->input('fullname');
        $phone = $request->input('phone');
        $username = $request->input('username');

        Customer::where('customerID',Auth::guard('customer')->id())->update([
            'fullname' => $fullname,
            'phone_number' => $phone,
            'username' => $username
        ]);

        Session::put([
            'fullname' => $fullname,
            'phone_number' => $phone,
            'username' => $username
        ]);

        session()->flash('details_updated',"Profile details updated successfully");

        return to_route('customer_profile');
    }

    //Profile Image Update
    public function updateProfile(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'profile_image' => 'required|image|mimes:jpg,jpeg,png',
        ]);
        // Get the uploaded file
        $file = $request->file('profile_image');

        // Define the upload path
        $uploadPath = 'Images/profile_images/';

        // Generate a unique name for the image
        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

        // Move the file to the specified folder
        $file->move(public_path($uploadPath), $fileName);

        $customer = DB::table('customers')->where('username', Session::get('username'))->first();
        $profileUpdate = Customer::find($customer->{'customerID'});

        $profileUpdate->profile_img = $fileName;
        $profileUpdate->save();

        Session::put('profile_img',$fileName);
        session()->flash('profile_image',"Profile Image Successfully Updated");
        return to_route('customer_profile');
    }

    public function updateMilage(Request $request){
        $vehicleID = $request->input('milage_update');

        Vehicle::where('vehicleID',$vehicleID)->update([
            'milage' => $request->input('current_mileage'),
        ]);

        return to_route('customer_profile');
    }
}
