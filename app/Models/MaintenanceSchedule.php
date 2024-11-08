<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceSchedule extends Model
{
    use HasFactory;
    protected $fillable = [
        'vehicleID',
        'customerID',
        'maintenance_type',
        'PMS_services',
        'scheduled_date',
        'last_maintenance_date',
        'scheduled_interval',
        'oil_type',
        'current_milage',
        'next_milage_schedule',
        'isAppointed',
        'appointment_date',
        'isDeactivated',
    ];

    protected $table = 'maintenance_schedules';

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicleID', 'vehicleID');
    }
}
