<?php

namespace App\Exports;

use App\Models\MaintenanceHistory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class HistoryExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $transactions = MaintenanceHistory::select('historyID', 'owner', 'vehicle', 'previous_milage', 'current_milage', 'maintenance_type', 'oil_type', 'pms_services', 'cost', 'maintenance_description', 'maintenance_status', 'date_performed')->whereYear('date_performed', date('Y'))->get();;
        return $transactions;
    }

    public function headings(): array
    {
        return ['History ID', 'Owner', 'Vehicle', 'Previous Mileage', 'Current Mileage', 'Maintenance Type', 'Oil Type', 'PMS Services', 'Cost', 'Maintenance Description', 'Maintenance Status', 'Date Performed'];
    }
}
