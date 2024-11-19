<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    //Reset Password View
    public function resetPasswordView(){
        return view('pages.reset_password.reset_password_view');
    }

    public function resetPassword(Request $request){
        $email = $request->input('email');
        $validate = $request->validate(
            [
                'register_password' => 'min:8',
                'confirm_password' => 'same:register_password',
            ],
            [
                'register_password.min' => 'The password must be at least 8 characters long',
                'confirm_password.same' => 'Password does not match',
            ]
        );

        $customer_email = Customer::where('email',$email)->first();
        if($customer_email){
            Customer::where('email',$email)->update([
                'password' => Hash::make($request->input('register_password')),
            ]);
            session()->flash('password_changed', "Password Successfully Changed");
           return to_route('login_view');
        } else {
            return redirect()->route('reset_password_view')->with('error', 'Email address does not exist.');        
        }
    }
}
