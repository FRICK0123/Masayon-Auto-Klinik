<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ManagerManagementController extends Controller
{
    //User Management Page View
    public function managersView()
    {
        $customer = Customer::where('usertype','manager')->orderBy('fullname', 'asc')->get();
        $managerCount = $customer->count();
        $onlineCount = Customer::where('usertype', 'manager')
        ->where('last_seen', '>=', Carbon::now()->subMinutes(3))  // Active in the last 3 minutes
        ->where('last_seen', '<=', Carbon::now())  // Ensuring it's not a future time
        ->count();
        return view('pages.admin_pages.admin_manager_management', ["users" => $customer,'managerCount'=>$managerCount,'onlineCount'=>$onlineCount]);
    }

    //Add User to the database
    public function storeManager(Request $request)
    {
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
            'isDeactivated' => false,
            'usertype' => 'manager',
            'last_seen' => Carbon::now(),
        ]);

        session()->flash('manager_created', "Manager Successfully Registered");

        return to_route('managers_view');
    }

    //Users Filter
    public function managerFilter(Request $request)
    {
        $filter_value = $request->input('filter_managers');

        if ($filter_value == "by_fullname") {
            $user = Customer::where('usertype', 'manager')->orderBy('fullname', 'asc')->get();
        } elseif ($filter_value == "by_username") {
            $user = Customer::where('usertype', 'manager')->orderBy('username', 'asc')->get();
        } elseif ($filter_value == "by_creation") {
            $user = Customer::where('usertype', 'manager')->orderBy('created_at', 'desc')->get();
        }
        $managerCount = $user->count();
        $onlineCount = Customer::where('usertype', 'manager')
        ->where('last_seen', '>=', Carbon::now()->subMinutes(3))  // Active in the last 3 minutes
        ->where('last_seen', '<=', Carbon::now())  // Ensuring it's not a future time
        ->count();

        return view('pages.admin_pages.admin_manager_management', ["users" => $user, 'managerCount' => $managerCount, 'onlineCount' => $onlineCount]);
    }

    //View manager page
    public function viewManagerInfo($customerID)
    {
        $customer = Customer::where('customerID', $customerID)->where('usertype','manager')->first();
        return view('pages.admin_pages.admin_users.admin_view_manager', ['customer' => $customer]);
    }
}
