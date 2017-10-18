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
            $table->string('num_ticket',10);
            $table->string('serial', 10);
            $table->date('date');
            $table->time('hour');
            $table->integer('sellers_agency_id')->unsigned(); // determina el usuario
            $table->foreign('sellers_agency_id')->references('id')->on('sellers_agency');
            $table->decimal('total', 16, 2);
            $table->string('status')->default('ACTIVO');
            $table->timestamps();
            
//             $table->string('employee');
//             $table->string('client');
//             $table->string('doc');
//             $table->string('phone');
//             $table->string('address');
//             $table->decimal('amount_received', 10, 2);
            
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
