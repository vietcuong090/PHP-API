<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('doctor_schedules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('doctor_id')->unsigned();
            $table->integer('day_of_week');
            $table->time('start_time');
            $table->time('end_time');
            // $table->foreign('doctor_id')->references('id')->on('doctors');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctor_schedules');
    }
};