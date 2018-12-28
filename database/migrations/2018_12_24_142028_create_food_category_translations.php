<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFoodCategoryTranslations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('food_category_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('food_category_id')->unsigned();
            $table->string('title');
            $table->string('locale')->index();

            $table->unique(['food_category_id','locale']);
            $table->foreign('food_category_id')->references('id')->on('food_categories')->onDelete('cascade');
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
        Schema::dropIfExists('food_category_translations');
    }
}
