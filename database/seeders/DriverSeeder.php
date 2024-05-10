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
            'driver_name' => "John C. Delmas",
            'license_number' => '1245FSDF',
            'contact_number' => '09391687338',
            'driver_status' => 'available',
        ]);
        
        Driver::create([ 
            'driver_name' => 'Argel D. Valdez',
            'license_number' => 'ABCD1234',
            'contact_number' => '09292170529',
            'driver_status' => 'available',
        ]);

        Driver::create([ 
            'driver_name' => 'Anatolio T. Garcia Jr.',
            'license_number' => 'EFGH5678',
            'contact_number' => '09993559398',
            'driver_status' => 'available',
        ]);

        Driver::create([ 
            'driver_name' => 'Gregory T. Sudaypan',
            'license_number' => 'IJKL9012',
            'contact_number' => '09192144418',
            'driver_status' => 'available',
        ]);

        Driver::create([ 
            'driver_name' => 'Wilmer T. Toribio',
            'license_number' => 'MNOP3456',
            'contact_number' => '09070872046',
            'driver_status' => 'available',
        ]);

        Driver::create([ 
            'driver_name' => 'Reyner A. Berato',
            'license_number' => 'QRST7890',
            'contact_number' => '09102684953',
            'driver_status' => 'available',
        ]);

     

    }
}
