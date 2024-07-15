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
            $table->smallInteger('kadar');
            $table->bigInteger('harga_beli');
            $table->bigInteger('harga_buyback');
            $table->string('codename', 50)->nullable()->unique();
            $table->smallInteger('barcode')->nullable();
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
