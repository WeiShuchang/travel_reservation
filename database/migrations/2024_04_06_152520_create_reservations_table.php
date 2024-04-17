<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->string('requestor_name', 100);
            $table->string('office_department_college', 50);
            $table->string('contact_number');
            $table->string('appointment_status', 50);
            $table->string('requestor_address')->nullable();
            $table->integer('number_of_passengers');
            $table->string('destination', 50);
            
            $table->date('date_of_travel')->nullable();
            $table->string('purpose_of_travel')->nullable();

            $table->boolean('is_approved')->default(false)->nullable();
            $table->boolean('is_successful')->default(false)->nullable();
            $table->boolean('is_cancelled')->default(false)->nullable();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('driver_id')->nullable();
            $table->foreign('driver_id')->references('id')->on('drivers')->onDelete('cascade');

            $table->unsignedBigInteger('car_id')->nullable();
            $table->foreign('car_id')->references('id')->on('cars')->onDelete('cascade');

            $table->date('expected_return_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservations');
    }
}
