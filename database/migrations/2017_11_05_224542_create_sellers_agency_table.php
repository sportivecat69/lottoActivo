<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSellersAgencyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sellers_agency', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('agencies_id')->unsigned();
            $table->foreign('agencies_id')->references('id')->on('agencies');
            $table->integer('users_id')->unsigned();
            $table->foreign('users_id')->references('id')->on('users');
            $table->integer('printer_id')->unsigned();
            $table->foreign('printer_id')->references('id')->on('printers');
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
        Schema::dropIfExists('sellers_agency');
    }
}
