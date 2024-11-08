<?php

namespace App\Http\Controllers\ManagerDashboard;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\MaintenanceHistory;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerManagementController extends Controller
{
    public function customersView(Request $request)
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

        if ($request->has('search_customers') && $request->input('search_customers') !== '') {
            $searchTerm = $request->input('search_customers');

            $query = Customer::where('fullname', 'LIKE', "%{$searchTerm}%")->where('usertype','customer')->orWhere('username', 'LIKE', "%{$searchTerm}%")->where('usertype', 'customer')->orWhere('email', 'LIKE', "%{$searchTerm}%")->where('usertype', 'customer');
        }

        // Paginate with filter parameters
        $customer = $query->paginate(10)->appends($request->except('page'));

        // Pass the filtered/ordered customers to the view
        return view(
            'pages.manager_pages.manager_customer_management',
            [
                'users' => $customer,
                'customerCount' => $customerCount,
                'onlineCount' => $onlineCount,
            ]
        );
    }

    //Add User to the database
    public function storeUser(Request $request)
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
            'usertype' => 'customer',
            'last_seen' => Carbon::now(),
        ]);

        return to_route('customer_management');
    }

    //View Users page
    public function viewUserInfo(Request $request,$customerID)
    {
        $customer = Customer::where('customerID', $customerID)->first();
        $vehicles = Vehicle::where('customerID', $customerID)->get();
        $query = MaintenanceHistory::where('customerID', $customerID)->orderBy('date_performed', 'desc');
        $previous_maintenance = $query->paginate(2)->appends($request->except('page'));
        return view('pages.manager_pages.manager_view_customer_info', ['customer' => $customer, 'vehicles' => $vehicles, 'previous_maintenance' => $previous_maintenance]);
    }

}
