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
        Schema::create('cashflows', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // user_id juga di perulukan, apabila semisal untuk entry pengeluaran yang tidak ada kaitannya dengan pembelian pelanggan
            $table->bigInteger('time_key'); // pada saat sorting dan filter, sulit apabila hanya mengandalkan surat_pembelian_id saja, karena mungkin saja terjadi penjualan pada surat_id terkait, sehingga sulit membentuk collection nya pada halaman index neraca.
            $table->foreignId('surat_pembelian_id')->nullable()->constrained()->onDelete('set null'); // nullable karena pemasukan bisa jadi belum tentu dari pembelian item perhiasan
            $table->foreignId('surat_pembelian_item_id')->nullable()->constrained()->onDelete('set null'); // nullable karena pemasukan bisa jadi belum tentu dari pembelian item perhiasan
            // string karena bisa jadi array, ada beberapa item_id dari pembelian_id terkait, bisa jadi semua item dalam satu pembelian atau hanya beberapa saja.
            // $table->foreignId('penjualan_id')->nullable()->constrained()->onDelete('cascade');
            // Masalah ketika pakai array, nanti pas mencari di database jadi lebih sulit.
            // $table->string('nama_transaksi',50)->nullable(); //, ['mix'= campur, 'bba' = bb-able, 'non' => non-bb-able] pembelian-perhiasan, penjualan-perhiasan, mutasi-ke-tunai, mutasi-dari-bca, penyesuaian
            $table->enum('tipe',['pemasukan', 'pengeluaran'])->nullable();
            $table->string('tipe_wallet',50)->nullable(); // tunai, bank, e-wallet
            $table->string('nama_wallet',50)->nullable(); // tunai, bca, bri, bni, mandiri, ovo, gopay, dana, dll.
            $table->integer('jumlah')->nullable(); // nullable karena masih belum bisa jelas apabila semua barang dalam satu surat pembelian dijual semua, lalu penjualan tersebut kombinasi antara tunai dan non-tunai
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cashflows');
    }
};
