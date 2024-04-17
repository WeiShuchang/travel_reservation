<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{

    use HasFactory;

    protected $fillable = [
        'requestor_name',
        'office_department_college',
        'contact_number',
        'appointment_status',
        'requestor_address',
        'number_of_passengers',
        'destination',
        'date_of_travel',
        'purpose_of_travel',
        'user_id',

        'is_approved',
        'is_successful',
        'is_cancelled',
        
        'driver_id',
        'car_id',
        'expected_return_date',
    ];

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

 
}
