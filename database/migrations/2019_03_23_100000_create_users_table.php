<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('email', 190)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('mobile_no')->nullable();
            $table->string('aadhar')->nullable();
            $table->string('pan')->nullable();
            $table->string('company')->nullable();
            $table->string('gstin')->nullable();
            $table->string('type')->nullable();
            $table->boolean('status')->nullable();
            $table->string('address')->nullable();
            $table->unsignedInteger('city_id')->nullable();
            $table->unsignedInteger('state_id')->nullable();
            $table->unsignedInteger('country_id')->nullable();
            $table->string('postcode')->nullable();
            $table->string('otp')->nullable();
            $table->dateTime('otp_created_at')->nullable();
            $table->boolean('is_verified')->default(0);
            $table->unsignedInteger('vendor_id')->nullable();
            $table->string('image')->nullable();
            $table->date('expire_date')->nullable();
            $table->string('license_no')->nullable();
            $table->boolean('dl_type')->nullable();
            $table->boolean('role')->nullable();
            $table->rememberToken();
            $table->string('pan_image')->nullable();
            $table->string('aadhar_image')->nullable();
            $table->string('gstin_image')->nullable();
            $table->string('cin_image')->nullable();
            $table->string('current_lat')->nullable();
            $table->string('current_lng')->nullable();
            $table->boolean('is_set_location')->nullable()->default(0);
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->auditable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
