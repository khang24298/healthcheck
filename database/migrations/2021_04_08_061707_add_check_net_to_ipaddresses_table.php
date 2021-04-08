<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCheckNetToIpaddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ipaddresses', function (Blueprint $table) {
            $table->boolean('isNetCheck')->default(false);
            $table->boolean('isInternetConnect')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ipaddresses', function (Blueprint $table) {
            //
        });
    }
}
