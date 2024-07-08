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
        Schema::create('matas', function (Blueprint $table) {
            $table->id();
            $table->string('warna', 20);
            $table->string('level_warna', 20); // neutral, tua, muda
            $table->string('opacity', 20); // transparent, half-transparent, non-transparent
            $table->string('codename', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matas');
    }
};
