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
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->string('kategori_wallet', 20); // tunai atau non-tunai
            $table->string('tipe_wallet', 20); // laci, bank atau ewallet
            $table->string('nama_wallet', 20)->unique(); // tunai, BCA atau GoPay
            $table->decimal('saldo', 15, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallets');
    }
};
