<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    public function verify($token)
    {
        $user = Customer::where('verification_token', $token)->first();

        if (!$user) {
            return redirect('/')->with('error', 'Invalid verification token.');
        }

        $user->email_verified_at = now();
        $user->verification_token = null; // Invalidate the token
        $user->save();

        return redirect('/login')->with('success', 'Your email has been verified!');
    }
}
