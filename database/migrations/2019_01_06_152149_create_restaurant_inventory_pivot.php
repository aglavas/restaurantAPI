<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRestaurantInventoryPivot extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurant_category_inventory_pivot', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('restaurant_id')->unsigned();
            $table->integer('inventory_id')->unsigned();
            $table->foreign('restaurant_id')->references('id')->on('restaurants')->onDelete('cascade');
            $table->foreign('inventory_id')->references('id')->on('restaurant_inventory_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('restaurant_category_inventory_pivot');
    }
}
