<?php

use App\Http\Controllers\Account\LoginController;
use App\Http\Controllers\Account\RegisterController;
use App\Http\Controllers\AdminDashboard\AdminAppointmentController;
use App\Http\Controllers\AdminDashboard\AdminController;
use App\Http\Controllers\AdminDashboard\CarsController;
use App\Http\Controllers\AdminDashboard\MaintenanceHistoryController;
use App\Http\Controllers\AdminDashboard\MaintenanceOverviewController;
use App\Http\Controllers\AdminDashboard\MaintenanceStatusController;
use App\Http\Controllers\AdminDashboard\ManagerManagementController;
use App\Http\Controllers\AdminDashboard\ReportController;
use App\Http\Controllers\AdminDashboard\UserManagementController;
use App\Http\Controllers\Dashboard\AppointmentController;
use App\Http\Controllers\Dashboard\CarController;
use App\Http\Controllers\Dashboard\CustomerDashboard;
use App\Http\Controllers\Dashboard\MaintenanceController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\ManagerDashboard\ManagerDashboardController;
use App\View\Components\AdminDashboard\MaintenanceOverviewContent;
use App\View\Components\AdminDashboard\UserManagementContent;
use Illuminate\Contracts\Foundation\MaintenanceMode;
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

//Verify Email
Route::get('/verify-email/{token}', [EmailVerificationController::class, 'verify'])->name('verify.email');

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
        Route::get('/pending_view','pendingView')->name('pending_view');
    });
//end

//Profile Image and Profile Details Route
    Route::controller(ProfileController::class)->group(function(){
        Route::get('/profile_view', 'profileView')->name('profile_view');
        Route::post('/profile_upload', 'profileUpload')->name('profile_upload');
    });
//End

//Add, Edit, and Delete car routes
    Route::middleware(['auth:customer','update.last_seen'])->controller(CarController::class)->group(function() {
        Route::get('/car_view','addCarView')->name('car_view');
        Route::post('/add_car', 'addCar')->name('add_car');
        Route::post('/view_car/{vehicleID}', 'viewCarDetails')->name('view_car_details');
    });
//end

//Routes for Maintenance Schedule and History
    Route::middleware(['auth:customer','update.last_seen'])->controller(MaintenanceController::class)->group(function(){
        Route::get('/schedule_form/{vehicleID}', 'scheduleMaintenanceView')->name('schedule_maintenance_form');
        Route::post('/schedule_maintenance_store', 'scheduleMaintenance')->name('schedule_maintenance_store');
    });
//end

//Routes for Customer Schedule Appointment
    Route::middleware(['auth:customer', 'update.last_seen'])->controller(AppointmentController::class)->group(function () {
        Route::get('/scheduled_appointment', 'appointmentView')->name('appointment_view');
    });
//end

//Routes for Customers Dashboard
    Route::middleware(['auth:customer','update.last_seen'])->controller(CustomerDashboard::class)->group(function(){
        Route::get('/dashboard', 'customerDashboardView')->name('customer_dashboard');
        Route::get('/profile', 'customerProfileView')->name('customer_profile');
        Route::get('/maintenance_schedule', 'scheduleView')->name('customer_maintenance_schedule');
    });
//end

/*----------ADMIN----------*/

//Routes for Admin Dashboard
    Route::middleware(['auth:admin'])->controller(AdminController::class)->group(function(){
        Route::get('/admin_dashboard', 'adminDashboardView')->name('admin_dashboard');
    });
//end

//Routes for Admin Car page
    Route::middleware(['auth:admin'])->controller(CarsController::class)->group(function(){
        Route::get('/cars','adminCarsView')->name('admin_cars');
        Route::get('/add_car_form','carFormView')->name('car_form');
        Route::post('/car_store','storeCar')->name('store_car');
        Route::get('/car_filter', 'carFilter')->name('car_filter');
        Route::post('/edit_car/{id}', 'carEdit')->name('edit_car');
        Route::delete('/delete_car/{id}','carDelete')->name('delete_car');
    });
//end

//Routes for Admin User Management
    Route::middleware(['auth:admin'])->controller(UserManagementController::class)->group(function(){
        Route::get('/user_management','usersView')->name('users_view');
        Route::post('/register_user','storeUser')->name('store_user');
        Route::get('/user_filter','userFilter')->name('user_filter');
        Route::get('/view_user/{customerID}', 'viewUserInfo')->name('view_user_info');
        Route::get('/view_user_vehicles/{customerID}', 'viewUserVehicleInfo')->name('view_user_vehicle_info');
        Route::get('/add_user_vehicle/{customerID}','addVehicleView')->name('add_vehicle_view');
        Route::post('/store_user_vehicle{customerID}','addUserVehicle')->name('store_user_vehicle');
        Route::get('/add_user_vehicle_maintenance_schedule/{vehicleID}', 'addUserVehicleMaintenanceScheduleView')->name('add_user_vehicle_maintenance_schedule_view');
        Route::post('/store_vehicle_maintenance', 'scheduleMaintenance')->name('store_maintenance_schedule');
        Route::get('/edit_user/{customerID}','editUserInfoView')->name('edit_user_info_view');
        Route::post('/update_user/{customerID}', 'editUserInfo')->name('edit_user_info');
        Route::post('/change_password/{customerID}', 'changePassword');
        Route::get('/walkin_maintenance/{vehicleID}', 'walkinMaintenanceView')->name('walkin_maintenance_view');
        Route::post('/walkin', 'walkinMaintenance')->name('walkin_maintenance');
    });
//end

//Routes for Admin Manager User Management
    Route::middleware(['auth:admin'])->controller(ManagerManagementController::class)->group(function(){
        Route::get('/manager_management', 'managersView')->name('managers_view');
        Route::post('/register_manager','storeManager')->name('store_manager');
        Route::get('/manager_filter','managerFilter')->name('manager_filter');
        Route::get('/view_manager/{customerID}', 'viewManagerInfo')->name('view_manager_info');
    });
//end

//Routes for Admin Maintenance Overview
    Route::middleware(['auth:admin'])->controller(MaintenanceOverviewController::class)->group(function (){
        Route::get('/maintenance_overview', 'maintenanceOverview')->name('maintenance_overview');
    });
//end

//Routes for Admin Maintenance History
    Route::middleware(['auth:admin'])->controller(MaintenanceHistoryController::class)->group(function () {
        Route::get('/maintenance_history', 'maintenanceHistoryView')->name('maintenance_history');
    });
//end

//Routes for Admin Maintenance Status
    Route::middleware(['auth:admin'])->controller(MaintenanceStatusController::class)->group(function () {
        Route::get('/maintenance_status', 'maintenanceStatusView')->name('maintenance_status_view');
        Route::post('/maintenance_status/update', 'MaintenanceStatusUpdate')->name('maintenance_status_update');
    });
//end

//Routes for Admin Reports
    Route::middleware(['auth:admin'])->controller(ReportController::class)->group(function () {
        Route::get('/reports', 'reportsView')->name('reports_view');
        Route::get('/reports/transaction_filter', 'reportsTransactionFilter')->name('reports_transaction_filter');
    });
//end

//Routes for Admin Appointment
    Route::middleware(['auth:admin'])->controller(AdminAppointmentController::class)->group(function () {
        Route::get('/customer_appointements', 'adminAppointmentView')->name('admin_appointment_view');
    });
//end

/*----------MANAGERS----------*/
//Routes for Admin Dashboard
Route::middleware(['auth:customer'])->controller(ManagerDashboardController::class)->group(function () {
    Route::get('/manager_dashboard', 'managerDashboardView')->name('manager_dashboard');
});
//end
