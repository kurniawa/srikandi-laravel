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
        Schema::create('tipe_perhiasans', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('photo_path')->nullable();
            $table->string('codename', 50)->nullable()->unique();
            $table->integer('barcode')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipe_perhiasans');
    }
};
