<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('vehicle_id');
            $table->timestamps();

            $table->foreign('vehicle_id')->references('id')->on('vehicles');
            $table->foreign('client_id')->references('id')->on('branchoffices');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchases');
    }
}
