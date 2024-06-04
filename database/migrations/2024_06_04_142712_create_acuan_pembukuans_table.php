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
        Schema::create('acuan_pembukuans', function (Blueprint $table) {
            $table->id();
            $table->enum('tipe',['pemasukan', 'pengeluaran']);
            $table->string('kategori', 50);
            $table->string('kategori_2', 50);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acuan_pembukuans');
    }
};
