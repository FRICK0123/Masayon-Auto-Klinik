<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

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
    ];
}
