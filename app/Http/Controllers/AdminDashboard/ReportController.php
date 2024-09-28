<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Http\Controllers\Controller;
use App\Models\MaintenanceHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    //reports view and filter
    public function reportsView(Request $request)
    {
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
                $transaction = MaintenanceHistory::where('date_performed', Carbon::today())->get();
        }

        return view('pages.admin_pages.admin_reports',
        [
            'transaction'=>$transaction,
            'interval'=>$interval,
        ]);
    }
}
