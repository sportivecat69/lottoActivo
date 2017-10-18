<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgencyCategoriesSellTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agency_categories_sell', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('categorie_id')->unsigned();
            $table->foreign('categorie_id')->references('id')->on('categories');
            $table->integer('agencies_id')->unsigned();
            $table->foreign('agencies_id')->references('id')->on('agencies');
            $table->integer('bet_min'); // apuesta minima
            $table->integer('prize_min'); // premio minimo
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
        Schema::dropIfExists('agency_categories_sell');
    }
}
