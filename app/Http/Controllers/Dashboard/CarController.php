<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CarController extends Controller
{
    //New Car Page View
    public function addCarView(){
        return view('pages.customer_pages.add_new_car');
    }
}
