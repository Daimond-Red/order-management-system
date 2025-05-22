<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->string('quantity')->nullable();
            $table->unsignedInteger('product_id')->nullable();
            $table->string('product_type')->nullable();
            $table->unsignedInteger('warehouse_id')->nullable();
            $table->unsignedInteger('attribute_value_id')->nullable();
            $table->string('type')->nullable();
            $table->string('source_entity_type')->nullable();
            $table->unsignedInteger('instance_id')->nullable();
            $table->unsignedInteger('source_entity_id')->nullable();
            $table->string('serial_no')->nullable();
            $table->string('batch')->nullable();
            $table->boolean('status')->default(true)->nullable();
            $table->text('remarks')->nullable();

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
        Schema::dropIfExists('stocks');
    }
}
