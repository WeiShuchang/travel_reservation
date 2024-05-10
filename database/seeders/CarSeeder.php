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
            'make' => 'FORTUNER',
            'model' => 'Toyota',
            'year' => 2020,
            'color' => 'Silver',
            'plate_number' => 'SJV 107',
            'transmission' => 'Automatic',
            'fuel_type' => 'Gasoline',
            'seat_capacity' => '4',
            'car_status' => 'available'
        ]);

        Car::create([
            'make' => 'ESTATE VAN',
            'model' => 'Nissan',
            'year' => 2020,
            'color' => 'Silver',
            'plate_number' => 'SKA 939',
            'transmission' => 'Automatic',
            'fuel_type' => 'Gasoline',
            'seat_capacity' => '10',
            'car_status' => 'available'
        ]);

        Car::create([
            'make' => 'REVO',
            'model' => 'Toyota',
            'year' => 2020,
            'color' => 'Silver',
            'plate_number' => 'SEL 944',
            'transmission' => 'Automatic',
            'fuel_type' => 'Gasoline',
            'seat_capacity' => '4',
            'car_status' => 'available'
        ]);


        Car::create([
            'make' => 'HI ACE',
            'model' => 'Toyota',
            'year' => 2020,
            'color' => 'Silver',
            'plate_number' => 'SFH 273',
            'transmission' => 'Automatic',
            'fuel_type' => 'Gasoline',
            'seat_capacity' => '9',
            'car_status' => 'available'
        ]);

        Car::create([
            'make' => 'VX',
            'model' => 'Toyota',
            'year' => 2020,
            'color' => 'Silver',
            'plate_number' => 'SDN 570',
            'transmission' => 'Automatic',
            'fuel_type' => 'Gasoline',
            'seat_capacity' => '4',
            'car_status' => 'available'
        ]);
        
        Car::create([
            'make' => 'BUS',
            'model' => 'Yutong',
            'year' => 2020,
            'color' => 'Silver',
            'plate_number' => 'SAB 5998',
            'transmission' => 'Automatic',
            'fuel_type' => 'Gasoline',
            'seat_capacity' => '45',
            'car_status' => 'available'
        ]);

    }
}
