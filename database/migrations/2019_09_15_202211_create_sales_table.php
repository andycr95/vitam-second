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
        Schema::create('sales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('amount');
            $table->date('date');
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('branchoffice_id');
            $table->unsignedBigInteger('vehicle_id');
            $table->timestamps();

            $table->foreign('vehicle_id')->references('id')->on('vehicles');
            $table->foreign('branchoffice_id')->references('id')->on('branchoffices');
            $table->foreign('client_id')->references('id')->on('clients');
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
