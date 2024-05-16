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
        Schema::create('surat_pembelian_item_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('surat_pembelian_item_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->string('path');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_pembelian_item_photos');
    }
};
