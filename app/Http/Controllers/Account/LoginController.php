<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function loginView(){
        return view('pages.login_page');
    }

    public function loginAuth(Request $request){
        $validate = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if(Auth::guard('customer')->attempt($validate)){
                $customer = DB::table('customers')->where('customerID',Auth::guard('customer')->id())->first();
                if($customer->{'email_verified_at'} === null || $customer->{'isVerified'} === 0){
                    Session::flush();
                    return to_route('pending_view');
                } else if($customer->{'usertype'}=="customer"){
                    //Sessions
                        Session::put([
                            'customerID' => $customer->{'customerID'},
                            'fullname' => $customer->{'fullname'},
                            'email' => $customer->{'email'},
                            'phone_number' => $customer->{'phone_number'},
                            'username' => $customer->{'username'},
                            'profile_img' => $customer->{'profile_img'},
                            'usertype' => $customer->{'usertype'},
                        ]);
                    //end

                    Customer::where('customerID',$customer->{'customerID'})->update(['last_seen'=>Carbon::now()]);
                    return to_route('customer_profile');
                } else {
                    //Sessions
                    Session::put([
                        'customerID' => $customer->{'customerID'},
                        'fullname' => $customer->{'fullname'},
                        'email' => $customer->{'email'},
                        'phone_number' => $customer->{'phone_number'},
                        'username' => $customer->{'username'},
                        'profile_img' => $customer->{'profile_img'},'usertype' => $customer->{'usertype'},
                    ]);
                    //end

                    Customer::where('customerID', $customer->{'customerID'})->update(['last_seen' => Carbon::now()]);
                    return to_route('manager_dashboard');
                }
        } else if(Auth::guard('admin')->attempt($validate)){
            $admin = Admin::where('adminID',Auth::guard('admin')->id())->first();
            Session::put([
                'adminID' => $admin['adminID'],
                'admin_logo' => $admin['admin_logo'],
                'email' => $admin['email'],
                'phone_number' => $admin['phone_number'],
                'username' => $admin['username'],
            ]);
            return to_route('admin_dashboard');
        } else {
            session()->flash('no_account',"Username and Password doesn't match!");
            return to_route('login_view');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('homepage');
    }
}
