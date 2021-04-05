<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFileExecToQueueMonitorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('queue_monitor', function (Blueprint $table) {
            //
            $table->string('file_exec')->default('supervisor/exec/first_check.sh');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('queue_monitor', function (Blueprint $table) {
            //
            $table->dropIfExists('file_exec');
        });
    }
}
