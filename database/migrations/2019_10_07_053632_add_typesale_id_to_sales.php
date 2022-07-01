<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTypesaleIdToSales extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->unsignedBigInteger('typesale_id');

            $table->foreign('typesale_id')->references('id')->on('type_sales');
            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sales', function (Blueprint $table) {
            //
        });
    }
}
