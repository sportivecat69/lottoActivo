<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaleInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_invoices', function (Blueprint $table) { // ticket
            $table->increments('id');
            $table->integer('sellers_agency_id')->unsigned(); // determina el usuario
            $table->foreign('sellers_agency_id')->references('id')->on('sellers_agency');
            $table->decimal('total', 16, 2);
            $table->string('status')->default('ACTIVO');
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
        Schema::dropIfExists('sale_invoices');
    }
}
