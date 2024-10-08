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
        Schema::create('kadars', function (Blueprint $table) {
            $table->id();
            $table->string('kategori', 50);
            $table->string('tipe', 20);
            $table->smallInteger('kadar');
            $table->smallInteger('poin_susut')->nullable();
            $table->smallInteger('poin_tambah')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kadars');
    }
};
