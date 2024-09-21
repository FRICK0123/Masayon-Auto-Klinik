<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'maintenanceID',
        'vehicleID',
        'customerID',
        'owner',
        'vehicle',
        'previous_milage',
        'current_milage',
        'maintenance_type',
        'cost',
        'maintenance_description',
        'maintenance_status',
        'date_performed',
    ];
}
