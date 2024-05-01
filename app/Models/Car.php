<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Car extends Model
{
    protected $fillable = [
        'make',
        'model',
        'year',
        'color',
        'plate_number',
        'mileage',
        'engine_size',
        'transmission',
        'fuel_type',
        'car_picture',
        'car_status',
        'seat_capacity',
    ];

    public function getCarPictureUrlAttribute()
    {
        if ($this->car_picture) {
            return asset('storage/drivers/' . $this->car_picture);
        }
        return asset('images/default-car.jpg');
    }


    public function getPlateNumberAttribute($value)
    {
        return strtoupper($value);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
