<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{
    use HasFactory;
    protected $primaryKey = "customerID";
    protected $guard = 'customer';

    protected $fillable = [
        'fullname',
        'email',
        'phone_number',
        'username',
        'password',
        'profile_img',
    ];
}
