<?php

use App\Http\Controllers\Account\LoginController;
use App\Http\Controllers\Account\RegisterController;
use App\Http\Controllers\Dashboard\CustomerDashboard;
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

//Routes for Customers Dashboard
    Route::controller(CustomerDashboard::class)->group(function(){
        Route::get('/Dashboard', 'customerDashboardView')->name('customer_dashboard');
    });
//end
