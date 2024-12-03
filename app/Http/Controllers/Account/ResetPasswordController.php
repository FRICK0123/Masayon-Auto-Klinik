<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    //Reset Password View
    public function resetPasswordView(){
        return view('pages.reset_password.reset_password_view');
    }

    public function emailExist(Request $request){
        $email = $request->input('email');
        $otp = Str::random(6);

        $customer = Customer::where('email',$email)->first();
        if($customer){
            // Store OTP and its creation time in session
            session([
                'otp' => $otp,
                'otp_email' => $customer->email,
                'otp_sent_at' => now(),
            ]);

            // Send the OTP email
            Mail::send('emails.otp', ['otp' => $otp], function ($message) use ($customer) {
                $message->to($customer->email)
                ->subject('Your OTP for Password Reset');
            });
            // Redirect to the OTP verification page
            return redirect()->route('verify_otp_view');
        } else {
            return redirect()->route('reset_password_view')->with('error', 'Email address does not exist.');        
        }
    }

    // Show OTP verification page
    public function verifyOtpView()
    {
        return view('pages.reset_password.verify_otp');
    }

    // Verify OTP
    public function verifyOtp(Request $request)
    {
        // Retrieve OTP from session
        $otp = session('otp');
        $email = session('otp_email');
        $otp_sent_at = session('otp_sent_at');

        // Check if OTP is valid and within the time window (10 minutes)
        if ($otp && $otp == $request->input('otp') && $otp_sent_at) {
            if ($otp_sent_at->diffInMinutes(now()) <= 10) {
                // OTP is valid, redirect to password reset form
                return redirect()->route('reset_password_page', ['email' => $email]);
            } else {
                // OTP has expired
                return redirect()->route('verify_otp_view')->with('error', 'OTP has expired.');
            }
        } else {
            // Invalid OTP
            return redirect()->route('verify_otp_view')->with('error', 'Invalid OTP.');
        }
    }

    // Show password reset form
    public function resetPasswordPage($email)
    {
        return view('pages.reset_password.reset_password_page', ['email' => $email]);
    }

    // Reset the password
    public function resetPassword(Request $request)
    {
        $email = $request->input('email');
        $request->validate([
            'register_password' => 'min:8',
            'confirm_password' => 'same:register_password',
        ], [
            'register_password.min' => 'The password must be at least 8 characters long.',
            'confirm_password.same' => 'Password does not match.',
        ]);

        // Update password in the database
        $customer = Customer::where('email', $email)->first();
        if ($customer) {
            $customer->update([
                'password' => bcrypt($request->input('register_password')),
            ]);
            session()->flash('password_changed', 'Password Successfully Changed');
            return redirect()->route('login_view');
        } else {
            return redirect()->route('reset_password_view')->with('error', 'Email address does not exist.');
        }
    }
}
