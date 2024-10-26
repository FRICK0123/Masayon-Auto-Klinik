<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Charts\TransactionChart;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\MaintenanceHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    //reports view and filter
    public function reportsView()
    {
        $today = Carbon::parse(Carbon::today()->toDateString());
        $transaction = MaintenanceHistory::where('date_performed', $today)->orderBy('date_performed','desc')->get();
        $interval = 'daily';
        return view('pages.admin_pages.admin_reports',
        [
            'transaction'=>$transaction,
            'interval'=>$interval,
        ]);
    }

    //Filter for transaction interval
    public function reportsTransactionFilter(Request $request)
    {
        $today = Carbon::parse(Carbon::today()->toDateString());
        // Default to daily if no filter is applied
        $interval = $request->input('interval', 'daily');
        // Adjust based on interval
        switch ($interval) {
            case 'weekly':
                $transaction = MaintenanceHistory::whereBetween('date_performed', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->orderBy('date_performed','desc')->get();
                break;
            case 'monthly':
                $transaction = MaintenanceHistory::whereBetween('date_performed', [
                    Carbon::now()->startOfMonth(),
                    Carbon::now()->endOfMonth()
                ])->orderBy('date_performed','desc')->get();
                break;
            case 'yearly':
                $transaction = MaintenanceHistory::whereBetween('date_performed', [
                    Carbon::now()->startOfYear(),
                    Carbon::now()->endOfYear()
                ])->orderBy('date_performed','desc')->get();
                break;
            default:
                $transaction = MaintenanceHistory::where('date_performed', $today)->orderBy('date_performed','desc')->get();
        }


        return view(
            'pages.admin_pages.admin_reports',
            [
                'transaction' => $transaction,
                'interval' => $interval,
            ]
        );
    }

    public function reportsTransactionByDate(Request $request){
        $selectedDate = Carbon::parse($request->input('selected_date'));
        // Query the transactions based on the selected date
        $transaction = MaintenanceHistory::whereDate('date_performed', $selectedDate)->get();

        // Pass the transactions and the selected date to the view
        return view('pages.admin_pages.admin_reports', [
            'transaction' => $transaction,
            'interval' => Carbon::parse($selectedDate)->format('F j, Y'), // Optional: You can set a custom interval label
        ]);
    }

    //Customers Reports
    //Customer Reports View
    public function customerReportsView(){
        $today = Carbon::parse(Carbon::today()->toDateString());
        $customers = Customer::where('usertype', 'customer')->whereDate('created_at', $today)->orderBy('created_at', 'desc')->get();
        $interval = 'daily';
        return view(
            'pages.admin_pages.admin_customer_reports',
            [
                'customers' => $customers,
                'interval' => $interval,
            ]
        );
    }

    //Filter for transaction interval
    public function customerReportsFilter(Request $request)
    {
        $today = Carbon::parse(Carbon::today()->toDateString());
        // Default to daily if no filter is applied
        $interval = $request->input('interval', 'daily');
        // Adjust based on interval
        switch ($interval) {
            case 'weekly':
                $customers = Customer::where('usertype', 'customer')->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->orderBy('created_at', 'desc')->get();
                break;
            case 'monthly':
                $customers = Customer::where('usertype', 'customer')->whereBetween('created_at', [
                    Carbon::now()->startOfMonth(),
                    Carbon::now()->endOfMonth()
                ])->orderBy('created_at', 'desc')->get();
                break;
            case 'yearly':
                $customers = Customer::where('usertype', 'customer')->whereBetween('created_at', [
                    Carbon::now()->startOfYear(),
                    Carbon::now()->endOfYear()
                ])->orderBy('created_at', 'desc')->get();
                break;
            default:
                $customers = Customer::where('usertype', 'customer')->whereDate('created_at', $today)->orderBy('created_at', 'desc')->get();
        }


        return view(
            'pages.admin_pages.admin_customer_reports',
            [
                'customers' => $customers,
                'interval' => $interval,
            ]
        );
    }

    public function customerReportsByDate(Request $request)
    {
        $selectedDate = Carbon::parse($request->input('selected_date'));
        // Query the transactions based on the selected date
        $customers = Customer::where('usertype', 'customer')->whereDate('created_at', $selectedDate)->get();

        // Pass the transactions and the selected date to the view
        return view('pages.admin_pages.admin_customer_reports', [
            'customers' => $customers,
            'interval' => Carbon::parse($selectedDate)->format('F j, Y'), // Optional: You can set a custom interval label
        ]);
    }
}
