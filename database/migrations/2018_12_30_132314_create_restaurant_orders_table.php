<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRestaurantOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurant_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('price');
            $table->enum('status', ['pending', 'preparing', 'ordering', 'finished']);
            $table->integer('restaurant_id')->unsigned();
            $table->string('name');
            $table->string('address');
            $table->foreign('restaurant_id')->references('id')->on('restaurants')->onDelete('cascade');
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
        Schema::dropIfExists('restaurant_orders');
    }
}
