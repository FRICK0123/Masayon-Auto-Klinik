<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class RegisterController extends Controller
{
    //Registration View
    public function registerView(){
        return view('pages.registration_views.register_page');
    }

    //Registration Details Session to be passed to the Regisration review details
    public function registrationViewSession(Request $request){
        $fullname = $request->input('register_fullname');
        $email = $request->input('register_email');
        $phone = $request->input('register_phone');
        $username = $request->input('register_username');
        $password = $request->input('register_password');

        Session::put([
            'fullname' => $fullname,
            'email' => $email,
            'phone' => $phone,
            'username' => $username,
        ]);

        //Session::put('hashed_password', Hash::make($password));
        Session::put('plain_password', $password);

        return view('pages.registration_views.user_summary');
    }

    //Registration Summary Form details stored to database
    public function registrationStore(Request $request){
        $fullname = $request->input('fullname');
        $email = $request->input('email');
        $phone = $request->input('phone');
        $username = $request->input('username');
        $password = Hash::make($request->input('password'));
        
        Customer::create([
            'fullname' => $fullname,
            'email' => $email,
            'phone_number' => $phone,
            'username' => $username,
            'password' => $password,
            'profile_img' => "default_user.png",
        ]);
        Session::flush();
        
        return view('pages.registration_views.user_profile_img');
    }
}
