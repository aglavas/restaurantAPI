<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRestaurantCategoryTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurant_category_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('restaurant_category_id')->unsigned();
            $table->string('title');
            $table->string('locale')->index();

            $table->unique(['restaurant_category_id','locale'], 'res_cat_trans_uniq');
            $table->foreign('restaurant_category_id', 'rest_cat_trans_for')->references('id')->on('restaurant_categories')->onDelete('cascade');
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
        Schema::dropIfExists('restaurant_category_translations');
    }
}
