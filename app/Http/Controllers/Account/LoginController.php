<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
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
                if($customer->{'email_verified_at'} === null){
                    Session::flush();
                    return to_route('pending_view');
                } else {
                    //Sessions
                        Session::put([
                            'customerID' => $customer->{'customerID'},
                            'fullname' => $customer->{'fullname'},
                            'email' => $customer->{'email'},
                            'phone_number' => $customer->{'phone_number'},
                            'username' => $customer->{'username'},
                            'profile_img' => $customer->{'profile_img'},
                        ]);
                    //end
                    return to_route('customer_dashboard');
                }
        } else {
            echo "Not logged";
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
