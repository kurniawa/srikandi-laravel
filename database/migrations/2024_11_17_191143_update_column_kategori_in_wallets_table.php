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
        Schema::table('wallets', function (Blueprint $table) {
            $table->renameColumn('kategori', 'kategori_wallet');
            $table->renameColumn('tipe', 'tipe_wallet');
            $table->renameColumn('nama', 'nama_wallet');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wallets', function (Blueprint $table) {
            $table->renameColumn('kategori_wallet', 'kategori');
            $table->renameColumn('tipe_wallet', 'tipe');
            $table->renameColumn('nama_wallet', 'nama');
        });
    }
};
