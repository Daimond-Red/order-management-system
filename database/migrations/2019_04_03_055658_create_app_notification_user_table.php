<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppNotificationUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_notification_user', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('app_notification_id')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->foreign('app_notification_id')->references('id')->on('app_notifications')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('app_notification_user');
    }
}
