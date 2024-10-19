<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\MaintenanceHistory;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarController extends Controller
{
    //New Car Page View
    public function addCarView(){
        $cars = Car::orderBy('car_make','asc')->get();
        return view('pages.customer_pages.add_new_car',['cars'=>$cars]);
    }

    //Add Car
    public function addCar(Request $request){
        $validated = $request->validate([
            'year_of_manufacture' => 'required|integer|between:1900,' . date('Y'),
        ]);
        $car_make = $request->input('car_make');
        $car_model = $request->input('car_model');
        $year_of_manufacture = $request->input('year_of_manufacture');
        $milage = $request->input('milage');
        $engine_number = $request->input('engine_number');
        $vehicle_identification_number = $request->input('vehicle_identification_number');
        $chassis_number = $request->input('chassis_number');
        $plate_number = $request->input('plate_number');
        $engine_type = $request->input('engine_type');

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
            $car_image = $request->input('car_image_hidden');
        }

        Vehicle::create([
            'customerID' => Auth::guard('customer')->id(),
            'make' => $car_make,
            'model' => $car_model,
            'year_of_manufacture' => $year_of_manufacture,
            'vehicle_image' => $car_image,
            'milage' => $milage,
            'engine_number' => $engine_number,
            'vehicle_identification_number' => $vehicle_identification_number,
            'chassis_number' => $chassis_number,
            'engine_type' => $engine_type,
            'plate_number' => $plate_number,
        ]);

        return to_route('customer_dashboard');
    }

    //View car details
    public function viewCarDetails(Request $request,$vehicleID){
        $vehicle = Vehicle::where('vehicleID',$vehicleID)->first();
        $query = MaintenanceHistory::where('vehicleID', $vehicleID);
        $transactions = $query->paginate(5)->appends($request->except('page'));
        return view('pages.customer_pages.view_car',['vehicle'=>$vehicle,'transactions'=>$transactions]);
    }
}
