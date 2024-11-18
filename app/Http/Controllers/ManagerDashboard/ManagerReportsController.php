<?php

namespace App\Http\Controllers\ManagerDashboard;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\MaintenanceHistory;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ManagerReportsController extends Controller
{
    //Manager Reports View
    public function reportsView(Request $request)
    {
        $today = Carbon::parse(Carbon::today()->toDateString());
        $interval = 'daily';

        // Get the search query from the form
        $searchQuery = $request->input('search_report');

        // Modify the query to filter by search term if provided
        $transaction = MaintenanceHistory::where('date_performed', $today)
        ->when($searchQuery, function ($query, $searchQuery) {
            return $query->where('vehicle', 'like', '%' . $searchQuery . '%')
            ->orWhere('vehicle', 'like', '%' . $searchQuery . '%')
            ->orWhere('owner', 'like', '%' . $searchQuery . '%')
            ->orWhere('maintenance_type', 'like', '%' . $searchQuery . '%');
        })
        ->orderBy('date_performed', 'desc')
        ->paginate(6); // Paginate with 6 records per page

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

    public function customerReportsView(Request $request)
    {
        $today = Carbon::parse(Carbon::today()->toDateString());

        // Get the search query if it exists
        $searchQuery = $request->input('search_customer');

        // Modify the query to filter by search term if provided
        $customers = Customer::where('created_at', $today)->where('usertype','customer')
        ->when($searchQuery, function ($query, $searchQuery) {
            return $query->where('fullname', 'LIKE', '%' . $searchQuery . '%')
                ->orWhere('email', 'LIKE', '%' . $searchQuery . '%')
                ->orWhere('phone_number', 'LIKE', '%' . $searchQuery . '%')
                ->orWhere('username', 'LIKE', '%' . $searchQuery . '%');
        })
        ->orderBy('created_at', 'desc')
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
                $customers = Customer::whereDate('created_at', $today)
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

    //Customer Vehicles
    public function customerVehiclesView(Request $request)
    {
        // Retrieve unique values for dropdowns from the database
        $makes = Vehicle::select('make')->distinct()->pluck('make');
        $models = Vehicle::select('model')->distinct()->pluck('model');
        $years = Vehicle::select('year_of_manufacture')->distinct()->pluck('year_of_manufacture');

        // Query builder for vehicle data
        $query = Vehicle::with('customer')->orderBy('created_at', 'desc');

        // Apply filters based on the dropdown selections
        if ($request->filled('make')) {
            $query->where('make', $request->make);
        }
        if ($request->filled('model')) {
            $query->where('model', $request->model);
        }
        if ($request->filled('year')) {
            $query->where('year_of_manufacture', $request->year);
        }

        $vehicles = $query->get();
        $vehicleCount = $vehicles->count();

        return view('pages.manager_pages.manager_customer_vehicles_reports', [
            'vehicles' => $vehicles,
            'vehicleCount' => $vehicleCount,
            'makes' => $makes,
            'models' => $models,
            'years' => $years,
        ]);
    }
}
