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
        Schema::create('user_alamats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('tipe', ['UTAMA', 'CADANGAN'])->default('CADANGAN');
            $table->string('alamat_baris_1')->nullable();
            $table->string('alamat_baris_2')->nullable();
            $table->string('alamat_baris_3')->nullable();
            $table->string("jalan", 50)->nullable();
            $table->string("komplek", 50)->nullable();
            $table->string("kawasan", 50)->nullable();
            $table->string("rt", 5)->nullable();
            $table->string("rw", 5)->nullable();
            $table->string("desa", 50)->nullable();
            $table->string("kelurahan", 50)->nullable();
            $table->string("kecamatan", 50)->nullable();
            $table->string('provinsi', 50)->nullable();
            $table->string('kota', 50)->nullable();
            $table->string('kode_pos', 20)->nullable();
            $table->string("pulau", 50)->nullable();
            $table->string("negara", 50)->nullable();
            $table->string("singkat", 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_alamats');
    }
};
