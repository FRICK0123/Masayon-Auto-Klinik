<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Charts\TransactionChart;
use App\Http\Controllers\Controller;
use App\Models\MaintenanceHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    //reports view and filter
    public function reportsView()
    {
        $today = Carbon::parse(Carbon::today()->toDateString());
        $transaction = MaintenanceHistory::where('date_performed', $today)->get();
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
                $transaction = MaintenanceHistory::whereBetween('date_performed', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();
                break;
            case 'monthly':
                $transaction = MaintenanceHistory::whereBetween('date_performed', [
                    Carbon::now()->startOfMonth(),
                    Carbon::now()->endOfMonth()
                ])->get();
                break;
            case 'yearly':
                $transaction = MaintenanceHistory::whereBetween('date_performed', [
                    Carbon::now()->startOfYear(),
                    Carbon::now()->endOfYear()
                ])->get();
                break;
            default:
                $transaction = MaintenanceHistory::where('date_performed', $today)->get();
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
}
