<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\MaintenanceHistory;
use App\Models\MaintenanceSchedule;
use App\Models\Notification;
use App\Models\Vehicle;
use ArielMejiaDev\LarapexCharts\Facades\LarapexChart;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    //admin dashboard view
    public function adminDashboardView(){
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
        $customerCount = Customer::where('usertype','customer')->count();
        $vehicleCount = Vehicle::all()->count();
        $notificationCount = Notification::all()->count();

        $today = Carbon::parse(Carbon::today()->toDateString());
        $customer_daily_registration = Customer::where('usertype','customer')->whereDate('created_at', $today)->orderBy('created_at', 'desc')->get();
        $customer_weekly_registration = Customer::where('usertype','customer')->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->orderBy('created_at', 'desc')->get();

        $customer_daily_transactions= MaintenanceHistory::where('date_performed', $today)->orderBy('date_performed', 'desc')->get();
        $customer_weekly_transactions=MaintenanceHistory::whereBetween('date_performed',[Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek()])->orderBy('date_performed', 'desc')->get();

        //Charts Data
        // Get data for the monthly chart (for current month)
        $monthlyData = MaintenanceHistory::whereMonth('date_performed', date('m'))
            ->whereYear('date_performed', date('Y'))
            ->selectRaw('DAY(date_performed) as day, count(*) as transactions')
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        // Convert collections to arrays
        $monthlyDays = $monthlyData->pluck('day')->toArray();
        $monthlyTransactions = $monthlyData->pluck('transactions')->toArray();
        // Create the monthly chart
        $monthlyChart = LarapexChart::barChart()
            ->addData('Transactions', $monthlyTransactions)
            ->setXAxis($monthlyDays)
            ->setGrid(true)
            ->setStroke(2)
            ->setMarkers('blue', 5, 10)
            ->setTitle('Monthly Transaction History');

        // Get data for the yearly chart (for current year)
        $yearlyData = MaintenanceHistory::whereYear('date_performed', date('Y'))
            ->selectRaw('MONTH(date_performed) as month, count(*) as transactions')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Convert collections to arrays
        $months = $yearlyData->pluck('month')->map(function ($month) {
            return \Carbon\Carbon::createFromFormat('m', $month)->format('F');
        })->toArray();
        $yearlyTransactions = $yearlyData->pluck('transactions')->toArray();

        // Create the yearly chart
        $yearlyChart = LarapexChart::lineChart()
            ->addData('Transactions', $yearlyTransactions)
            ->setXAxis($months)
            ->setGrid(true)
            ->setStroke(2)
            ->setMarkers('blue', 5, 10)
            ->setTitle('Yearly Transaction History');

        return view('pages.admin_pages.admin_dashboard',[
            'schedules' => $schedules,
            'scheduleCount' => $scheduleCount,
            'customerCount' => $customerCount,
            'vehicleCount' => $vehicleCount,
            'notificationCount' => $notificationCount,
            'customer_daily_registration' => $customer_daily_registration,
            'customer_weekly_registration' => $customer_weekly_registration,
            'customer_daily_transaction' => $customer_daily_transactions,
            'customer_weekly_transaction' => $customer_weekly_transactions,
            'monthlyChart' => $monthlyChart,
            'yearlyChart' => $yearlyChart,
        ]);
    }
}
