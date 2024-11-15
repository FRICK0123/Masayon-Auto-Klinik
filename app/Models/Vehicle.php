<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $primaryKey = "vehicleID";
    protected $fillable = [
        'customerID',
        'vehicle_image',
        'make',
        'model',
        'year_of_manufacture',
        'milage',
        'engine_number',
        'vehicle_identification_number',
        'chassis_number',
        'plate_number',
        'engine_type',
        'isDeactivated',
    ];

    protected $table = 'vehicles';

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customerID', 'customerID');
    }

    public function maintenanceSchedule()
    {
        return $this->hasOne(MaintenanceSchedule::class, 'vehicleID', 'vehicleID');
    }
}
