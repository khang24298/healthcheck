<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class QueueMonitor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('queue_monitor', function(Blueprint $table){
            $table->id();
            $table->string('program_name')->unique();
            $table->boolean('autostart')->default(true);
            $table->boolean('autorestart')->default(true);
            $table->string('user')->default(null);
            $table->unsignedInteger('numprocs')->nullable();
            $table->boolean('redirect_stderr')->default(true);
            $table->unsignedInteger('stopwaitsecs')->default(3600);
            $table->unsignedInteger('sleep')->nullable();
            $table->unsignedInteger('tries')->nullable();
            $table->string('queue')->nullable();
            $table->unsignedInteger('timeout')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('queue_monitor');
    }
}
