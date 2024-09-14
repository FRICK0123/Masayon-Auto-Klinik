<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    //User Management Page View
    public function usersView(){
        $customer = Customer::orderBy('fullname','asc')->get();
        return view('pages.admin_pages.admin_user_management',["users"=>$customer]);
    }

}
