<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminProfileController extends Controller
{
    //Admin Profile View
    public function adminProfileView(){
        return view('pages.admin_pages.admin_profile');
    }

    //Change Customer Account Password
    public function changePassword(Request $request, $adminID)
    {
        $newPassword = Hash::make($request->input('new_password'));

        Admin::where('adminID', $adminID)->update(['password' => $newPassword]);
        session()->flash('password_changed', "Password Successfully Changed");
        return to_route('admin_profile');
    }
}
