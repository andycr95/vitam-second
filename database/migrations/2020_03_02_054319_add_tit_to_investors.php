<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTitToInvestors extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('investors', function (Blueprint $table) {
            $table->unsignedBigInteger('titular_id')->nullable();

            $table->foreign('titular_id')->references('id')->on('investors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('investors', function (Blueprint $table) {
            //
        });
    }
}
