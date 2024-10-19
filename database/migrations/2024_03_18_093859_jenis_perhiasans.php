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
        Schema::create('jenis_perhiasans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipe_perhiasan_id')->constrained()->onDelete('cascade')->onUpdate('cascade'); // tidak bisa nullable. Kalau tipe_perhiasan ada, masa tidak ada id nya?
            $table->string('tipe_perhiasan');
            $table->string('nama');
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
        //
    }
};
