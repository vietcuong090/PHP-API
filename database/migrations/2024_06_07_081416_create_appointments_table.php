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
        Schema::create('appointments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('service_id');
            $table->enum('appointment_type', ['first', 'return']);
            $table->enum('reservation_type', ['now', 'late']);
            $table->dateTime('booking_time');
            $table->unsignedBigInteger('user_id');
            $table->enum('status', ['reserved', 'accepted', 'cancel', 'completed']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
