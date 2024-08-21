<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarController extends Controller
{
    //New Car Page View
    public function addCarView(){
        return view('pages.customer_pages.add_new_car');
    }

    //Add Car
    public function addCar(Request $request){
        $validated = $request->validate([
            'year_of_manufacture' => 'required|integer|between:1900,' . date('Y'),
        ]);
        $car_make = $request->input('car_make');
        $car_model = $request->input('car_model');
        $year_of_manufacture = $request->input('year_of_manufacture');
        $plate_number = $request->input('plate_number');

        if($request->hasFile('car_image')){
            // Get the uploaded file
            $file = $request->file('car_image');

            // Define the upload path
            $uploadPath = 'Images/car_images/';

            // Generate a unique name for the image
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            // Move the file to the specified folder
            $file->move(public_path($uploadPath), $fileName);

            $car_image = $fileName;
        } else {
            $car_image = "sample_car.png";
        }

        Vehicle::create([
            'customerID' => Auth::guard('customer')->id(),
            'make' => $car_make,
            'model' => $car_model,
            'year_of_manufacture' => $year_of_manufacture,
            'vehicle_image' => $car_image,
            'plate_number' => $plate_number,
        ]);

        return to_route('customer_dashboard');
    }

    //View car details
    public function viewCarDetails($vehicleID){
        $vehicle = Vehicle::where('vehicleID',$vehicleID)->first();
        return view('pages.customer_pages.view_car',['vehicle'=>$vehicle]);
    }
}
