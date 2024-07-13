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
        Schema::create('accountings', function (Blueprint $table) {
            $table->id();
            $table->string('kode_accounting'); // Untuk Identifikasi ke Cashflow yang mana yang terkait dengan entry accounting ini
            $table->foreignId('surat_pembelian_id')->nullable()->constrained()->onDelete('cascade')->onUpdate('cascade'); // identifikasi surat atau item yang terkait
            $table->foreignId('surat_pembelian_item_id')->nullable()->constrained()->onDelete('cascade')->onUpdate('cascade'); // identifikasi surat atau item yang terkait
            $table->string('nama_barang')->nullable(); // identifikasi nama barang dan untuk mempermudah sorting, apabila diperlukan
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null')->onUpdate('cascade');
            $table->foreignId('supplier_id')->nullable()->constrained()->onDelete('set null');
            $table->string('supplier_name')->nullable();
            $table->enum('tipe', ['pemasukan', 'pengeluaran']);
            $table->string('kategori', 50)->nullable();
            $table->string('kategori_2', 50)->nullable();
            $table->string('deskripsi')->nullable();
            $table->bigInteger('jumlah'); // nullable karena masih belum bisa jelas apabila semua barang dalam satu surat pembelian dijual semua, lalu penjualan tersebut kombinasi antara tunai dan non-tunai
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accountings');
    }
};
