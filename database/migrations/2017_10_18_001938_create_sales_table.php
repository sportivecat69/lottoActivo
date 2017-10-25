<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {  // detalle del ticket
            $table->increments('id');
            $table->integer('sale_invoice_id')->unsigned(); // id_ticket
            $table->foreign('sale_invoice_id')->references('id')->on('sale_invoices');
            $table->integer('draws_id')->unsigned(); // id sorteo
            $table->foreign('draws_id')->references('id')->on('draws');
            $table->integer('articles_id')->unsigned(); // numero vendido segun categoria
            $table->foreign('articles_id')->references('id')->on('articles');
            $table->integer('bet'); //apuesta
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
        Schema::dropIfExists('sales');
    }
}
