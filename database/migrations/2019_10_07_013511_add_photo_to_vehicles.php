<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPhotoToVehicles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->string('photo')->nullable();
            $table->string('photo1')->nullable();
            $table->string('photo2')->nullable();
            $table->string('photo3')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vehicles', function (Blueprint $table) {
            //
        });
    }
}
