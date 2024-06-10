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
        Schema::create('location_regions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('zip_code');
            $table->unsignedBigInteger('province_id');
            $table->string('province_name');
            $table->unsignedBigInteger('district_id');
            $table->string('district_name');
            $table->unsignedBigInteger('ward_id');
            $table->string('ward_name');
            $table->string('address');
            $table->string('phone_number');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('location_regions');
    }
};