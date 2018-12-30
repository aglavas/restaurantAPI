<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRestaurantInventoryPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurant_inventory_pivot', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('restaurant_category_id')->unsigned();
            $table->integer('restaurant_inventory_id')->unsigned();
            $table->foreign('restaurant_category_id')->references('id')->on('restaurant_categories')->onDelete('cascade');
            $table->foreign('restaurant_inventory_id')->references('id')->on('restaurant_inventory_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('restaurant_inventory_pivot');
    }
}
