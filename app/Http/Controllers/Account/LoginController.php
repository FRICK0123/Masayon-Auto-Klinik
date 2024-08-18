<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            return to_route('customer_dashboard');
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
