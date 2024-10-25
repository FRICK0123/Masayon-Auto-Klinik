<?php

namespace App\Http\Controllers\ManagerDashboard;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\MaintenanceSchedule;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ManagerDashboardController extends Controller
{
    //Manager Dashboard View
    public function managerDashboardView(){
        $schedules = MaintenanceSchedule::with(['vehicle.customer'])
            ->where(function ($query) {
                // Condition for 'Oil Change' maintenance type
                $query->where('maintenance_type', 'Oil Change')
                    ->where(function ($subQuery) {
                        $subQuery->whereBetween('scheduled_date', [now(), Carbon::now()->addDays(7)])
                            ->orWhereColumn('current_milage', '>=', 'next_milage_schedule');
                    })
                    ->whereNotNull('oil_type')
                    ->whereNotNull('current_milage')
                    ->whereNotNull('next_milage_schedule');
            })
            ->orWhere(function ($query) {
                // Condition for 'Oil Change' maintenance type
                $query->where('maintenance_type', 'EGR Cleaning')
                    ->where(function ($subQuery) {
                        $subQuery->whereBetween('scheduled_date', [now(), Carbon::now()->addDays(7)])
                            ->orWhereColumn('current_milage', '>=', 'next_milage_schedule');
                    })
                    ->whereNotNull('current_milage')
                    ->whereNotNull('next_milage_schedule');
            })
            ->orWhere(function ($query) {
                // Condition for non-'Oil Change' maintenance type
                $query->where('maintenance_type', '!=', 'Oil Change')
                    ->whereBetween('scheduled_date', [now(), Carbon::now()->addDays(7)]);
            })
            ->get();
        $scheduleCount = $schedules->count();
        $customerCount = Customer::where('usertype', 'customer')->count();
        $vehicleCount = Vehicle::all()->count();

        $today = Carbon::parse(Carbon::today()->toDateString());
        $customer_daily_registration = Customer::where('usertype', 'customer')->whereDate('created_at', $today)->orderBy('created_at', 'desc')->get();
        $customer_weekly_registration = Customer::where('usertype', 'customer')->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->orderBy('created_at', 'desc')->get();

        return view('pages.manager_pages.manager_dashboard',[
            'schedules' => $schedules,
            'scheduleCount' => $scheduleCount,
            'customerCount' => $customerCount,
            'vehicleCount' => $vehicleCount,
            'customer_daily_registration' => $customer_daily_registration,
            'customer_weekly_registration' => $customer_weekly_registration,
        ]);
    }
}
