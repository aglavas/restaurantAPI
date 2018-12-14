<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWineryTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('winery_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('winery_id')->unsigned();
            $table->string('description');
            $table->string('locale')->index();

            $table->unique(['winery_id','locale']);
            $table->foreign('winery_id')->references('id')->on('wineries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('winery_translations');
    }
}
