<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('placa');
            $table->string('model');
            $table->string('color');
            $table->string('motor');
            $table->string('chasis');
            $table->unsignedBigInteger('investor_id');
            $table->unsignedBigInteger('type_id');
            $table->unsignedBigInteger('branchoffice_id');
            $table->timestamps();
            
            $table->foreign('branchoffice_id')->references('id')->on('branchoffices');
            $table->foreign('investor_id')->references('id')->on('investors');
            $table->foreign('type_id')->references('id')->on('types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicles');
    }
}
