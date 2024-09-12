<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CarsController extends Controller
{
    //Cars Page View
    public function adminCarsView(){
        return view('pages.admin_pages.admin_cars');
    }
}
