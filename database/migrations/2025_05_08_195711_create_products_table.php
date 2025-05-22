<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->unsignedInteger('brand_id')->nullable();
            $table->string('summary')->nullable();
            $table->string('description')->nullable();
            $table->string('sku')->nullable();
            $table->string('cover')->nullable();
            $table->string('warranty_in_months')->nullable();
            $table->string('warranty_in_days')->nullable();
            $table->string('service_type')->nullable();
            $table->string('type')->nullable();
            $table->boolean('active')->nullable()->default(true);

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
        Schema::dropIfExists('products');
    }
}
