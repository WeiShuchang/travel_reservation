<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;

    protected $fillable = ['driver_name', 'license_number', 'contact_number', 'driver_status', 'driver_picture'];

    // You can define the table name if it differs from the default convention
    // protected $table = 'drivers';

    // You can define any relationships here if needed

    public function getDriverPictureUrlAttribute()
    {
        if ($this->driver_picture) {
            return asset('storage/drivers/' . $this->driver_picture);
        }
        return asset('images/default-driver.jpeg');
    }
    

    public function __toString()
    {
        return "{$this->driver_name} {$this->contact_number}";
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
    
}
