<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->string('address')->nullable();
            $table->unsignedInteger('state_id')->nullable();
            $table->unsignedInteger('city_id')->nullable();
            $table->string('postcode')->nullable();
            $table->string('mobile_no')->nullable();
            $table->string('aadhar')->nullable();
            $table->string('pan')->nullable();
            $table->unsignedInteger('vehicle_type_id')->nullable();
            $table->string('capacity')->nullable();
            $table->string('no_of_tyres')->nullable();
            $table->string('length')->nullable();
            $table->string('breadth')->nullable();
            $table->string('hieght')->nullable();
            $table->string('vehicle_name')->nullable();
            $table->string('vehicle_num')->nullable();
            $table->string('permit_type')->nullable();
            $table->dateTime('expire_date')->nullable();
            $table->dateTime('fitness_validity')->nullable();
            $table->dateTime('insurance_validity')->nullable();
            $table->boolean('is_verified')->nullable();
            $table->unsignedInteger('start_state')->nullable();
            $table->unsignedInteger('start_city')->nullable();
            $table->string('end_cities')->nullable();
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('vehicle_type_id')->references('id')->on('vehicle_types')->onDelete('cascade');
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
        Schema::dropIfExists('vehicles');
    }
}
