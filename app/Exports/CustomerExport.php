<?php

namespace App\Exports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CustomerExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Customer::select('customerID', 'fullname', 'email', 'phone_number', 'username', 'email_verified_at', 'isVerified', 'isDeactivated', 'created_at')->where('usertype','customer')->get();
    }

    public function headings(): array
    {
        return ['Customer ID', 'Fullname', 'Email', 'Phone Number', 'Username', 'Email Verified At', 'isVerified', 'isDeactivated', 'Created At'];
    }
}
