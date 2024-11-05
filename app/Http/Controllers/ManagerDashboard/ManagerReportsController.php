<?php

namespace App\Http\Controllers\ManagerDashboard;

use App\Http\Controllers\Controller;
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
}
