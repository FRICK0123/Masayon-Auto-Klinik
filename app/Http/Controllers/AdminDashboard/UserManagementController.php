<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    //User Management Page View
    public function usersView(){
        $customer = Customer::orderBy('fullname','asc')->get();
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
            $user = Customer::orderBy('created_at', 'asc')->get();
        }

        return view('pages.admin_pages.admin_user_management', ["users" => $user]);
    }
}
