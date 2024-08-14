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
        Schema::create('surat_pembelians', function (Blueprint $table) {
            $table->id();
            $table->timestamp('tanggal_surat'); // ada created_at dan ada juga tanggal surat supaya datanya lengkap
            $table->string('nomor_surat')->unique(); // id.jumlah_item.time()-1.678.420.000
            $table->bigInteger('time_key'); // id.jumlah_item.time()-1.678.420.000
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('username', 50); // username
            // $table->enum('tipe_pelanggan',['customer','guest']); // tipe_pelanggan sepertinya juga tidak diperlukan, selama pelanggan_id = null, maka customer belum terdaftar
            $table->foreignId('pelanggan_id')->nullable()->constrained('users')->onDelete('set null'); // kalo data pelanggan dihapus, data transaksi yang udah dibuat tidak otomatis terhapus
            $table->string('pelanggan_nama')->nullable();
            $table->string('pelanggan_username')->nullable();
            $table->string('pelanggan_nik')->nullable();
            // $table->enum('guest_id',['A','B','C','D','E'])->nullable(); // guest_id tidak diperlukan di pembelian
            $table->string('keterangan')->nullable(); // jaga2 takutnya ada kondisi khusus yang ribet akhirnya perlu taro di keterangan
            $table->bigInteger('harga_total');
            $table->bigInteger('total_bayar');
            $table->bigInteger('sisa_bayar');
            $table->string('status_bayar', 20); // ['lunas','belum-lunas']
            $table->string('status_buyback', 20)->nullable(); // nullable untuk barang yang bukan perhiasan -> [null,'all','sebagian']
            $table->bigInteger('total_buyback')->nullable();
            // $table->enum('status_terima_bb',['lunas','belum-lunas'])->nullable();
            $table->timestamp('tanggal_buyback')->nullable(); // tanggal kapan terjual semua
            $table->foreignId('updated_by')->nullable()->constrained('users','id')->onDelete('set null');
            $table->string('photo_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_pembelians');
    }
};
