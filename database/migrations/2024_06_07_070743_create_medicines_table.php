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
        Schema::create('medicines', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->text('description');
            $table->string('form');
            $table->string('strength');
            $table->string('manufacturer');
            $table->text('usage');
            $table->text('side_effects');
            $table->text('notes');
            $table->text('ingredients');
            $table->decimal('price');
            $table->decimal('price_discount_monthly');
            $table->decimal('price_discount_quarterly');
            $table->decimal('price_discount_half_year');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};
