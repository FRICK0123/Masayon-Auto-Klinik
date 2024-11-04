<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $fillable = [
        'customerID',
        'vehicleID',
        'maintenanceID',
        'owner',
        'vehicle',
        'maintenance_type',
        'scheduled_date',
        'content',
        'isConfirmed',
    ];
}
