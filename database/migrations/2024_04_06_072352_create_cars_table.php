<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarsTable extends Migration
{
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('make');
            $table->string('model');
            $table->integer('year');
            $table->string('color');
            $table->string('plate_number');
            $table->integer('mileage');
            $table->decimal('engine_size', 8, 2);
            $table->string('transmission');
            $table->string('fuel_type')->nullable();
            $table->string('seat_capacity');
            $table->string('car_picture')->nullable();
            $table->string('car_status')->default('available');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cars');
    }
}
