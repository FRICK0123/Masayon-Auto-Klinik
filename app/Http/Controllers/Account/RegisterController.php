<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Notifications\VerifyEmailNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    //Registration View
    public function registerView(){
        return view('pages.customer_signup_prompt');
    }

    //Registration Details Session to be passed to the Regisration review details
    public function registrationViewSession(Request $request){
        $fullname = $request->input('register_fullname');
        $email = $request->input('register_email');
        $phone = $request->input('register_phone');

        $validate = $request->validate(
            [
                'register_password' => 'min:8',
                'confirm_password' => 'same:register_password',
                'register_username' => 'unique:customers,username',
                'register_email' =>'unique:customers,email'
            ],
            [
                'register_password.min' => 'The password must be at least 8 characters long',
                'confirm_password.same' => 'Password does not match', 
                'register_username.unique' => 'Username is already taken',
                'register_email.unique' => 'The email address is already registered.',
            ]
        );

        Session::put([
            'fullname' => $fullname,
            'email' => $email,
            'phone' => $phone,
            'username' => $validate['register_username'],
        ]);

        Session::put('plain_password', $validate['register_password']);

        return view('pages.registration_views.user_summary');
    }

    //Registration Summary Form details stored to database
    public function registrationStore(Request $request){
        
        $fullname = $request->input('fullname');
        $email = $request->input('email');
        $phone = $request->input('phone');
        $username = $request->input('username');
        $password = Hash::make($request->input('password'));
        
        $customer = Customer::create([
            'fullname' => $fullname,
            'email' => $email,
            'phone_number' => $phone,
            'username' => $username,
            'password' => $password,
            'profile_img' => "default_user.png",
            'verification_token' => Str::random(60),
            'isVerified' => false,
            'isDeactivated' => false,
            'usertype' => "customer",
            'last_seen' => Carbon::now(),
        ]);
        // Send verification email
        $customer->notify(new VerifyEmailNotification($customer));
        
        return redirect()->route('profile_view');
    }

    //Pending page view
    public function pendingView(){
        return view('pages.registration_views.account_pending');
    }

}
