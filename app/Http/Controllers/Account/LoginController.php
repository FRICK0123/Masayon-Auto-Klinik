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
            'username' => 'required',
            'password' => 'required',
        ]);

        if(auth()->guard('customer')->attempt($validate)){
            return view('pages.customer_pages.customer_dashboard');
        } else {
            echo "Not logged";
        }
    }
}
