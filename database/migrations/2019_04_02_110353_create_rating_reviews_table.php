<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRatingReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rating_reviews', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type')->nullable();
            $table->unsignedInteger('booking_id')->nullable();
            $table->unsignedInteger('rated_by_id')->nullable();
            $table->unsignedInteger('rated_id')->nullable();
            $table->string('rating')->nullable();
            $table->string('review')->nullable();
            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
            $table->foreign('rated_by_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('rated_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('rating_reviews');
    }
}
