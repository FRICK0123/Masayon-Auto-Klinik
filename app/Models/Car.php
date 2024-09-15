<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'car_image',
        'car_make',
        'car_model',
        'year_of_manufacture',
        'engine_type'
    ]; 
}
