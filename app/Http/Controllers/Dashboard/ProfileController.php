<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{
    //Profile Image Upload View
    public function profileView(){
        return view('pages.registration_views.user_profile_img');
    }

    //Profile Image Upload
    public function profileUpload(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'profile_image' => 'required|image|mimes:jpg,jpeg,png',
        ]);
        // Get the uploaded file
        $file = $request->file('profile_image');

        // Define the upload path
        $uploadPath = 'Images/profile_images/';

        // Generate a unique name for the image
        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

        // Move the file to the specified folder
        $file->move(public_path($uploadPath), $fileName);

        $customer = DB::table('customers')->where('username', Session::get('username'))->first();
        $profileUpdate = Customer::find($customer->{'customerID'});

        $profileUpdate->profile_img = $fileName;
        $profileUpdate->save();

        Session::flush();
        return redirect()->route('pending_view');
    }
}
