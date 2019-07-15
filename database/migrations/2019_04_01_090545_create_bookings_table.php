<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_no')->nullable();
            $table->boolean('order_type')->nullable();
            $table->unsignedInteger('vendor_id')->nullable();
            $table->unsignedInteger('customer_id')->nullable();
            $table->unsignedInteger('vehicle_type_id')->nullable();
            $table->unsignedInteger('cargo_type_id')->nullable();
            $table->string('custom_name')->nullable();
            $table->string('custom_phone')->nullable();
            $table->boolean('logistic_type')->nullable();
            $table->dateTime('start_date_time')->nullable();
            $table->dateTime('end_date_time')->nullable();
            $table->string('address')->nullable();
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->unsignedInteger('city_id')->nullable();
            $table->string('state')->nullable();
            $table->string('drop_location_address')->nullable();
            $table->string('drop_location_lat')->nullable();
            $table->string('drop_location_lng')->nullable();
            $table->unsignedInteger('drop_location_city_id')->nullable();
            $table->string('drop_location_state')->nullable();
            $table->string('status')->nullable();
            $table->string('distance')->nullable();
            $table->text('signature')->nullable();
            $table->string('otp')->nullable();
            $table->dateTime('otp_created_at')->nullable();
            $table->boolean('is_rated_by_customer')->nullable();
            $table->boolean('is_rated_by_vendor')->nullable();
            $table->string('customer_rating')->nullable();
            $table->string('vendor_rating')->nullable();
            $table->text('customer_review')->nullable();
            $table->text('vendor_review')->nullable();
            $table->string('customer_review_title')->nullable();
            $table->string('vendor_review_title')->nullable();
            $table->string('booking_amount')->nullable();
            $table->string('estimate_weight')->nullable();
            $table->foreign('customer_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('vehicle_type_id')->references('id')->on('vehicle_types')->onDelete('cascade');
            $table->foreign('cargo_type_id')->references('id')->on('cargo_types')->onDelete('cascade');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
            $table->foreign('drop_location_city_id')->references('id')->on('cities')->onDelete('cascade');
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
        Schema::dropIfExists('bookings');
    }
}
