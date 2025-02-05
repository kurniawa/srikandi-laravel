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
        Schema::create('harga_pasarans', function (Blueprint $table) {
            $table->id();
            $table->string('kategori', 50);
            $table->decimal('kadar', 6, 2);
            $table->decimal('harga_beli', 15, 2);
            $table->decimal('harga_buyback', 15, 2);
            $table->string('codename', 50)->nullable()->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('harga_pasarans');
    }
};
