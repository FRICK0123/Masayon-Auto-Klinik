<?php

use App\Http\Controllers\Account\LoginController;
use App\Http\Controllers\Account\RegisterController;
use App\Http\Controllers\Dashboard\CarController;
use App\Http\Controllers\Dashboard\CustomerDashboard;
use App\Http\Controllers\Dashboard\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('pages.homepage');
})->name('homepage');

//Routes for User Login
    Route::controller(LoginController::class)->group(function(){
        Route::get('/login','loginView')->name('login_view');
        Route::post('/login_auth', 'loginAuth')->name('login');
        Route::post('/logout', 'logout')->name('logout');
    });
//end

//Routes for User registration
    Route::controller(RegisterController::class)->group(function(){
        Route::get('/register','registerView')->name('register_view');
        Route::post('/registration_details', 'registrationViewSession')->name('register_details');
        Route::post('/registration_store', 'registrationStore')->name('register_store');
    });
//end

//Profile Image and Profile Details Route
    Route::controller(ProfileController::class)->group(function(){
        Route::get('/profile_view', 'profileView')->name('profile_view');
        Route::post('/profile_upload', 'profileUpload')->name('profile_upload');
    });
//End

//Add, Edit, and Delete car routes
    Route::controller(CarController::class)->group(function() {
        Route::get('/car_view','addCarView')->name('car_view');
    });
//end

//Routes for Customers Dashboard
    Route::controller(CustomerDashboard::class)->group(function(){
        Route::get('/Dashboard', 'customerDashboardView')->name('customer_dashboard');
        Route::get('/profile', 'customerProfileView')->name('customer_profile');
    });
//end
