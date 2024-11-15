<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;
use Symfony\Component\Console\Input\Input;

class CarsController extends Controller
{
    // Cars Page View
    public function adminCarsView(Request $request)
    {
        $cars = Car::orderBy('car_make', 'asc')->get(); // Default retrieval of all cars

        if ($request->has('search_cars') && $request->input('search_cars') !== '') {
            $searchTerm = $request->input('search_cars');

            // Execute the query to filter results based on the search term
            $cars = Car::where('car_make', 'LIKE', "%{$searchTerm}%")
                ->orWhere('car_model', 'LIKE', "%{$searchTerm}%")
                ->orWhere('year_of_manufacture', 'LIKE', "%{$searchTerm}%")
                ->orderBy('car_make', 'asc')
                ->get();
        }

        return view('pages.admin_pages.admin_cars', ['cars' => $cars]);
    }

    //Cars Form
    public function carFormView(){
        return view('pages.admin_pages.admin_add_new_car');
    }

    //Store Cars to the database
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

        session()->flash('car_added',"$car_make $car_model $car_year Added Successfully");
        return to_route('admin_cars');
    }

    //Cars Filter
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

    //Edit Cars Information
    public function carEdit(Request $request, $id){
        Car::where('id', $id)->update([
            'car_make' => $request->input('car_make'),
            'car_model' => $request->input('car_model'),
            'year_of_manufacture' => $request->input('car_year'),
            'engine_type' => $request->input('engine_type')
        ]);

        session()->flash('car_edited',"Car Details Edited Successfully");

        return redirect()->route('admin_cars');
    }

    //Delete car
    public function carDelete($id){
        $car = Car::where('id',$id)->first();
        $car->delete();

        session()->flash('car_deleted', "Car Deleted Successfully");

        return to_route('admin_cars');
    }
}
