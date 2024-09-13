<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;
use Symfony\Component\Console\Input\Input;

class CarsController extends Controller
{
    //Cars Page View
    public function adminCarsView(){
        $cars = Car::orderBy('car_make','asc')->get();
        return view('pages.admin_pages.admin_cars',['cars'=>$cars]);
    }

    public function carFormView(){
        return view('pages.admin_pages.admin_add_new_car');
    }

    public function storeCar(Request $request){
        if ($request->hasFile('car_image')) {
            // Get the uploaded file
            $file = $request->file('car_image');

            // Define the upload path
            $uploadPath = 'Images/car_images/';

            // Generate a unique name for the image
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            // Move the file to the specified folder
            $file->move(public_path($uploadPath), $fileName);

            $car_image = $fileName;
        }

        $car_make = $request->input('car_make');
        $car_model = $request->input('car_model');
        $car_year = $request->input('car_year');
        $engine_type = $request->input('engine_type');

        Car::create([
            'car_image' => $car_image,
            'car_make' => $car_make,
            'car_model' => $car_model,
            'year_of_manufacture' => $car_year,
            'engine_type' => $engine_type,
        ]);

        return to_route('admin_cars');
    }

    public function carFilter(Request $request){
        $filter_value = $request->input('filter_cars');
        $query = Car::query();

        if ($filter_value == "by_make") {
            $query->orderBy('car_make', 'asc');
        } elseif ($filter_value == "by_model") {
            $query->orderBy('car_model', 'asc');
        } elseif ($filter_value == "by_year") {
            $query->orderBy('year_of_manufacture', 'asc');
        }

        $cars = $query->get();
        // Check if it's an AJAX request
        if ($request->ajax()) {
            return view('partials.car_table', compact('cars'))->render();
        }

        return view('pages.admin_pages.admin_cars', ['cars' => $cars]);

    }
}
