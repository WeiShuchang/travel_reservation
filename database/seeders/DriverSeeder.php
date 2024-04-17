<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Driver;

class DriverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Driver::create([ 
            'driver_name' => 'John Doe',
            'license_number' => 'ABCD1234',
            'contact_number' => '1234567890',
            'driver_status' => 'available',
        ]);

        Driver::create([ 
            'driver_name' => 'Jane Smith',
            'license_number' => 'EFGH5678',
            'contact_number' => '9876543210',
            'driver_status' => 'available',
        ]);

        Driver::create([ 
            'driver_name' => 'Michael Johnson',
            'license_number' => 'IJKL9012',
            'contact_number' => '4567890123',
            'driver_status' => 'available',
        ]);

        Driver::create([ 
            'driver_name' => 'Emily Brown',
            'license_number' => 'MNOP3456',
            'contact_number' => '7890123456',
            'driver_status' => 'available',
        ]);

        Driver::create([ 
            'driver_name' => 'David Wilson',
            'license_number' => 'QRST7890',
            'contact_number' => '2345678901',
            'driver_status' => 'available',
        ]);

    }
}
