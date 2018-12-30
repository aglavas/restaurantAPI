<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRestaurantInventoryTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurant_inventory_category_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('restaurant_inventory_category_id')->unsigned();
            $table->string('title');
            $table->string('locale')->index();

            $table->unique(['restaurant_inventory_category_id','locale'], 'res_inv_trans_uniq');
            $table->foreign('restaurant_inventory_category_id', 'rest_inv_trans_for')->references('id')->on('restaurant_inventory_categories')->onDelete('cascade');
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
        Schema::dropIfExists('restaurant_inventory_translations');
    }
}
