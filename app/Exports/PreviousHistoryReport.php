<?php

namespace App\Exports;

use App\Models\MaintenanceHistory;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;

class PreviousHistoryReport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $year;

    public function __construct($year)
    {
        $this->year = $year;
    }

    public function collection()
    {
        $startOfYear = Carbon::createFromDate($this->year, 1, 1)->startOfDay();
        $endOfYear = Carbon::createFromDate($this->year, 12, 31)->endOfDay();

        return MaintenanceHistory::select(
            'historyID',
            'owner',
            'vehicle',
            'previous_milage',
            'current_milage',
            'maintenance_type',
            'oil_type',
            'pms_services',
            'cost',
            'maintenance_description',
            'maintenance_status',
            'date_performed'
        )
            ->whereBetween('date_performed', [$startOfYear, $endOfYear])
            ->orderBy('date_performed', 'asc')
            ->get();
    }


    public function headings(): array
    {
        return [
            'History ID',
            'Owner',
            'Vehicle',
            'Previous Milage',
            'Current Milage',
            'Maintenance Type',
            'Oil Type',
            'PMS Services',
            'Cost',
            'Maintenance Description',
            'Maintenance Status',
            'Date Performed',
        ];
    }
}
