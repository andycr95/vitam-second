<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBranchofficeIdToClients extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->unsignedBigInteger('branchoffice_id')->nullable()->default('1');
            $table->foreign('branchoffice_id')->references('id')->on('branchoffices');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            //
        });
    }
}
