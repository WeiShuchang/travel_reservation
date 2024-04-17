<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Car;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Car::create([
            'make' => 'Toyota',
            'model' => 'Camry',
            'year' => 2020,
            'color' => 'Silver',
            'plate_number' => 'ABC123',
            'mileage' => 25000,
            'engine_size' => '2',
            'transmission' => 'Automatic',
            'fuel_type' => 'Gasoline',
            'car_status' => 'available'
        ]);

        Car::create([
            'make' => 'Honda',
            'model' => 'Civic',
            'year' => 2018,
            'color' => 'Black',
            'plate_number' => 'XYZ456',
            'mileage' => 30000,
            'engine_size' => '1',
            'transmission' => 'Automatic',
            'fuel_type' => 'Gasoline',
            'car_status' => 'available'
        ]);

        Car::create([
            'make' => 'Ford',
            'model' => 'F-150',
            'year' => 2019,
            'color' => 'Red',
            'plate_number' => 'DEF789',
            'mileage' => 20000,
            'engine_size' => '3',
            'transmission' => 'Automatic',
            'fuel_type' => 'Gasoline',
            'car_status' => 'available'
        ]);

        Car::create([
            'make' => 'Chevrolet',
            'model' => 'Cruze',
            'year' => 2017,
            'color' => 'Blue',
            'plate_number' => 'GHI012',
            'mileage' => 35000,
            'engine_size' => '1',
            'transmission' => 'Automatic',
            'fuel_type' => 'Gasoline',
            'car_status' => 'available'
        ]);

        Car::create([ 
            'make' => 'BMW',
            'model' => '3 Series',
            'year' => 2021,
            'color' => 'White',
            'plate_number' => 'JKL345',
            'mileage' => 15000,
            'engine_size' => '2',
            'transmission' => 'Automatic',
            'fuel_type' => 'Gasoline',
            'car_status' => 'available'
        ]);

    }
}
