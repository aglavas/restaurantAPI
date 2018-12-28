<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFoodAdditionTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('food_addition_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('food_addition_id')->unsigned();
            $table->string('title');
            $table->string('locale')->index();

            $table->unique(['food_addition_id','locale']);
            $table->foreign('food_addition_id')->references('id')->on('food_additions')->onDelete('cascade');
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
        Schema::dropIfExists('food_addition_translations');
    }
}
