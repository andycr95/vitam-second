<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBranchofficesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branchoffices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('address');
            $table->unsignedBigInteger('city_id');
            $table->enum('state', ['activo', 'inactivo'])->default('activo');
            $table->timestamps();

            $table->foreign('city_id')->references('id')->on('cities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('branchoffices');
    }
}
