<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Charts\TransactionChart;
use App\Exports\CustomerExport;
use App\Exports\HistoryExport;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\MaintenanceHistory;
use App\Models\Vehicle;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    //reports view and filter
    public function reportsView()
    {
        $today = Carbon::parse(Carbon::today()->toDateString());
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        // Get all transactions for the current month
        $transactions = MaintenanceHistory::whereBetween('date_performed', [$startOfMonth, $endOfMonth])
            ->orderBy('date_performed', 'desc')
            ->get();

        // Initialize an array to store the number of transactions per day
        $transactionsPerDay = [];

        // Loop through each transaction and count them per day
        foreach ($transactions as $transaction) {
            $day = Carbon::parse($transaction->date_performed)->format('Y-m-d');
            if (!isset($transactionsPerDay[$day])) {    
                $transactionsPerDay[$day] = 0;
            }
            $transactionsPerDay[$day]++;
        }

        // Create an array with the days of the month and the corresponding transaction count
        $daysOfMonth = [];
        $transactionCounts = [];
        for ($i = 1; $i <= $endOfMonth->day; $i++) {
            $currentDay = Carbon::parse($startOfMonth->copy()->day($i))->format('Y-m-d');
            $daysOfMonth[] = $currentDay;
            $transactionCounts[] = $transactionsPerDay[$currentDay] ?? 0;
        }

        $interval = 'monthly';
        return view('pages.admin_pages.admin_reports', [
            'transactions' => $transactions,
            'interval' => $interval,
            'daysOfMonth' => $daysOfMonth,
            'transactionCounts' => $transactionCounts,
        ]);
    }

    public function reportsTransactionFilter(Request $request)
    {
        $interval = $request->input('interval', 'monthly');
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        // Default to monthly if no filter is applied
        switch ($interval) {
            case 'weekly':
                $transactions = MaintenanceHistory::whereBetween('date_performed', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                    ->orderBy('date_performed', 'desc')
                    ->get();
                break;
            case 'monthly':
                $transactions = MaintenanceHistory::whereBetween('date_performed', [$startOfMonth, $endOfMonth])
                ->orderBy('date_performed', 'desc')
                    ->get();
                break;
            case 'yearly':
                $transactions = MaintenanceHistory::whereBetween('date_performed', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])
                    ->orderBy('date_performed', 'desc')
                    ->get();
                break;
            default:
                $transactions = MaintenanceHistory::where('date_performed', Carbon::today()->toDateString())
                ->orderBy('date_performed', 'desc')
                    ->get();
        }

        // Initialize the transaction counts
        $transactionsPerDay = [];
        foreach ($transactions as $transaction) {
            $day = Carbon::parse($transaction->date_performed)->format('Y-m-d');
            if (!isset($transactionsPerDay[$day])) {
                $transactionsPerDay[$day] = 0;
            }
            $transactionsPerDay[$day]++;
        }

        // Prepare days and counts for the chart
        $daysOfMonth = [];
        $transactionCounts = [];
        for ($i = 1; $i <= $endOfMonth->day; $i++) {
            $currentDay = Carbon::parse($startOfMonth->copy()->day($i))->format('Y-m-d');
            $daysOfMonth[] = $currentDay;
            $transactionCounts[] = $transactionsPerDay[$currentDay] ?? 0;
        }

        return view('pages.admin_pages.admin_reports', [
            'transactions' => $transactions,
            'interval' => $interval,
            'daysOfMonth' => $daysOfMonth,
            'transactionCounts' => $transactionCounts,
        ]);
    }


    //Export Transactions PDF
    public function exportTransactionPdf(Request $request)
    {
        // Retrieve filtering parameters
        $interval = $request->input('interval', 'daily');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Apply filtering based on the date range and interval
        if ($startDate && $endDate) {
            $startDate = Carbon::parse($startDate);
            $endDate = Carbon::parse($endDate);
            $transaction = MaintenanceHistory::whereBetween('date_performed', [$startDate, $endDate])
            ->orderBy('date_performed', 'desc')
            ->get();
            $interval = "From " . $startDate->format('F j, Y') . " to " . $endDate->format('F j, Y');
        } else {
            switch ($interval) {
                case 'weekly':
                    $transaction = MaintenanceHistory::whereBetween('date_performed', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->orderBy('date_performed', 'desc')->get();
                    break;
                case 'monthly':
                    $transaction = MaintenanceHistory::whereBetween('date_performed', [
                            Carbon::now()->startOfMonth(),
                            Carbon::now()->endOfMonth()
                        ])->orderBy('date_performed', 'desc')->get();
                    break;
                case 'yearly':
                    $transaction = MaintenanceHistory::whereBetween('date_performed', [
                            Carbon::now()->startOfYear(),
                            Carbon::now()->endOfYear()
                        ])->orderBy('date_performed', 'desc')->get();
                    break;
                default:
                    $transaction = MaintenanceHistory::where('date_performed', Carbon::today()->toDateString())->orderBy('date_performed', 'desc')->get();
            }
        }

        // Generate the PDF with the filtered transactions
        $pdf = PDF::loadView('pages.admin_pages.pdf_reports.pdf_transactions', [
            'transaction' => $transaction,
            'interval' => $interval,
        ]);

        // Stream the PDF to the browser
        return $pdf->stream('transaction_report.pdf');
    }

    //Export Transactions Excel
    public function exportTransactionExcel(){
        return Excel::download(new HistoryExport, 'customer_transactions.xlsx');
    }

    public function reportsTransactionByDateRange(Request $request)
    {
        $startDate = Carbon::parse($request->input('start_date'));
        $endDate = Carbon::parse($request->input('end_date'));

        // Query transactions within the specified date range
        $transaction = MaintenanceHistory::whereBetween('date_performed', [$startDate, $endDate])
            ->orderBy('date_performed', 'desc')
            ->get();

        // Pass the transactions, start, and end dates to the view
        return view('pages.admin_pages.admin_reports', [
            'transaction' => $transaction,
            'interval' => "From " . $startDate->format('F j, Y') . " to " . $endDate->format('F j, Y'),
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

    public function exportCustomerPdf(Request $request)
    {
        // Retrieve filtering parameters
        $interval = $request->input('interval', 'daily');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $today = Carbon::parse(Carbon::today()->toDateString());

        // Apply filtering based on the date range and interval
        if ($startDate && $endDate) {
            $startDate = Carbon::parse($startDate);
            $endDate = Carbon::parse($endDate);
            $customers = Customer::where('usertype', 'customer')->whereBetween('created_at', [$startDate,$endDate])->orderBy('created_at','desc')->get();
            $interval = "From " . $startDate->format('F j, Y') . " to " . $endDate->format('F j, Y');
        } else {
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
        }

        // Generate the PDF with the filtered transactions
        $pdf = PDF::loadView('pages.admin_pages.pdf_reports.pdf_customer_registrations', [
            'customers' => $customers,
            'interval' => $interval,
        ]);

        // Stream the PDF to the browser
        return $pdf->stream('customer_registration_report.pdf');
    }

    //Export Transactions Excel
    public function exportCustomerExcel()
    {
        return Excel::download(new CustomerExport, 'registered_customers.xlsx');
    }

    public function customerReportsByDateRange(Request $request)
    {
        $startDate = Carbon::parse($request->input('start_date'));
        $endDate = Carbon::parse($request->input('end_date'));
        // Query the transactions based on the selected date
        $customers = Customer::where('usertype', 'customer')->whereBetween('created_at', [$startDate,$endDate])->orderBy('created_at','desc')->get();

        // Pass the transactions and the selected date to the view
        return view('pages.admin_pages.admin_customer_reports', [
            'customers' => $customers,
            'interval' => "From " . $startDate->format('F j, Y') . " to " . $endDate->format('F j, Y'),
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

        return view('pages.admin_pages.admin_customer_vehicles', [
            'vehicles' => $vehicles,
            'vehicleCount' => $vehicleCount,
            'makes' => $makes,
            'models' => $models,
            'years' => $years,
        ]);
    }

    public function generateCustomerVehiclesPdf(Request $request)
    {
        // Retrieve the filtered data using the same logic as customerVehiclesView
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

        // Prepare the data for the PDF
        $data = [
            'vehicles' => $vehicles,
            'vehicleCount' => $vehicleCount,
            'makes' => Vehicle::select('make')->distinct()->pluck('make'),
            'models' => Vehicle::select('model')->distinct()->pluck('model'),
            'years' => Vehicle::select('year_of_manufacture')->distinct()->pluck('year_of_manufacture'),
        ];

        // Generate the PDF using the pdf_customer_vehicles view
        $pdf = PDF::loadView('pages.admin_pages.pdf_reports.pdf_customer_vehicles', $data);

        // Stream the generated PDF
        return $pdf->stream('customer_vehicles_report.pdf');
    }
}
