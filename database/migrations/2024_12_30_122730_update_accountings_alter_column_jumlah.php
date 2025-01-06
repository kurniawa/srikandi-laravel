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
        Schema::table('accountings', function (Blueprint $table) {
            // Mengubah kolom 'jumlah' menjadi tipe decimal
            $table->decimal('jumlah', 15, 2)->change(); // maks 999 triliun
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('accountings', function (Blueprint $table) {
            // Mengembalikan kolom 'jumlah' ke tipe bigInt
            $table->bigInteger('jumlah')->change();
        });
    }
};
