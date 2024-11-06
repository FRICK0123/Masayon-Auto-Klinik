<?php

namespace App\Http\Controllers\ManagerDashboard;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\MaintenanceHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ManagerReportsController extends Controller
{
    //Manager Reports View
    public function reportsView(){
        $today = Carbon::parse(Carbon::today()->toDateString());
        $transaction = MaintenanceHistory::where('date_performed', $today)
            ->orderBy('date_performed', 'desc')
            ->paginate(6); // Paginate with 6 records per page

        $interval = 'daily';

        return view('pages.manager_pages.manager_reports', [
            'transaction' => $transaction,
            'interval' => $interval,
        ]);
    }

    public function managerReportsTransactionFilter(Request $request)
    {
        $today = Carbon::parse(Carbon::today()->toDateString());
        $interval = $request->input('interval', 'daily');

        switch ($interval) {
            case 'weekly':
                $transaction = MaintenanceHistory::whereBetween('date_performed', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ])->orderBy('date_performed', 'desc')->paginate(6)->appends(['interval' => $interval]);
                break;
            case 'monthly':
                $transaction = MaintenanceHistory::whereBetween('date_performed', [
                    Carbon::now()->startOfMonth(),
                    Carbon::now()->endOfMonth()
                ])->orderBy('date_performed', 'desc')->paginate(6)->appends(['interval' => $interval]);
                break;
            case 'yearly':
                $transaction = MaintenanceHistory::whereBetween('date_performed', [
                    Carbon::now()->startOfYear(),
                    Carbon::now()->endOfYear()
                ])->orderBy('date_performed', 'desc')->paginate(6)->appends(['interval' => $interval]);
                break;
            default:
                $transaction = MaintenanceHistory::where('date_performed', $today)
                    ->orderBy('date_performed', 'desc')
                    ->paginate(6)
                    ->appends(['interval' => $interval]);

        }

        return view('pages.manager_pages.manager_reports', [
            'transaction' => $transaction,
            'interval' => $interval,
        ]);
    }

    public function reportsTransactionByDateRange(Request $request)
    {
        $startDate = Carbon::parse($request->input('start_date'));
        $endDate = Carbon::parse($request->input('end_date'));

        // Query transactions within the specified date range
        $transaction = MaintenanceHistory::whereBetween('date_performed', [$startDate, $endDate])
            ->orderBy('date_performed', 'desc')
            ->paginate(6)
            ->appends([
                'start_date' => $startDate->toDateString(),
                'end_date' => $endDate->toDateString(),
            ]);

        // Pass the transactions, start, and end dates to the view
        return view('pages.manager_pages.manager_reports', [
            'transaction' => $transaction,
            'interval' => "From " . $startDate->format('F j, Y') . " to " . $endDate->format('F j, Y'),
            'start_date' => $startDate->toDateString(),
            'end_date' => $endDate->toDateString(),
        ]);
    }

    public function customerReportsView(){
        $today = Carbon::parse(Carbon::today()->toDateString());
        $customers = Customer::where('created_at', $today)
            ->orderBy('created_at', 'desc')
            ->where('usertype','customer')
            ->paginate(6); // Paginate with 6 records per page

        $interval = 'daily';

        return view('pages.manager_pages.manager_customer_reports', [
            'customers' => $customers,
            'interval' => $interval,
        ]);
    }

    public function managerCustomerRegistrationsFilter(Request $request)
    {
        $today = Carbon::parse(Carbon::today()->toDateString());
        $interval = $request->input('interval', 'daily');

        switch ($interval) {
            case 'weekly':
                $customers = Customer::whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ])->where('usertype', 'customer')->orderBy('created_at', 'desc')->paginate(6)->appends(['interval' => $interval]);
                break;
            case 'monthly':
                $customers = Customer::whereBetween('created_at', [
                    Carbon::now()->startOfMonth(),
                    Carbon::now()->endOfMonth()
                ])->where('usertype', 'customer')->orderBy('created_at', 'desc')->paginate(6)->appends(['interval' => $interval]);
                break;
            case 'yearly':
                $customers = Customer::whereBetween('created_at', [
                    Carbon::now()->startOfYear(),
                    Carbon::now()->endOfYear()
                ])->where('usertype', 'customer')->orderBy('created_at', 'desc')->paginate(6)->appends(['interval' => $interval]);
                break;
            default:
                $customers = Customer::where('created_at', $today)
                ->where('usertype','customer')
                ->orderBy('created_at', 'desc')
                ->paginate(6)
                ->appends(['interval' => $interval]);
        }

        return view('pages.manager_pages.manager_customer_reports', [
            'customers' => $customers,
            'interval' => $interval,
        ]);
    }

    public function reportCustomersByDateRange(Request $request)
    {
        $startDate = Carbon::parse($request->input('start_date'));
        $endDate = Carbon::parse($request->input('end_date'));

        // Query transactions within the specified date range
        $customers = Customer::whereBetween('created_at', [$startDate, $endDate])
        ->where('usertype', 'customer')
        ->orderBy('created_at', 'desc')
        ->paginate(6)
        ->appends([
            'start_date' => $startDate->toDateString(),
            'end_date' => $endDate->toDateString(),
        ]);

        // Pass the transactions, start, and end dates to the view
        return view('pages.manager_pages.manager_customer_reports', [
            'customers' => $customers,
            'interval' => "From " . $startDate->format('F j, Y') . " to " . $endDate->format('F j, Y'),
            'start_date' => $startDate->toDateString(),
            'end_date' => $endDate->toDateString(),
        ]);
    }
}
