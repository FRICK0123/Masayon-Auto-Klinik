<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    use HasFactory,Notifiable;
    protected $primaryKey = "customerID";
    protected $guard = 'customer';

    protected $fillable = [
        'fullname',
        'email',
        'phone_number',
        'username',
        'password',
        'profile_img',
        'email_verified_at',
        'verification_token',
        'isVerified',
        'usertype',
        'last_seen',
    ];

    protected $dates = [
        'email_verified_at',
    ];

    protected $table = 'customers';
    public function vehicles(){
        return $this->hasMany(Vehicle::class, 'customerID', 'customerID');
    }
}
