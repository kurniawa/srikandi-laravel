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
        Schema::create('saldos', function (Blueprint $table) {
            $table->id();
            $table->string('kategori_wallet',20)->nullable(); // tunai, non-tunai
            $table->string('tipe_wallet',20)->nullable(); // laci, bank, e-wallet
            $table->string('nama_wallet',20); // tunai, bca, bri, bni, mandiri, ovo, gopay, dana, dll.
            $table->integer('saldo_awal');
            $table->integer('saldo_akhir');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saldos');
    }
};
