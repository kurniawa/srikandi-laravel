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
            $table->string('no_surat')->unique(); // id.jumlah_item.time()-1.678.420.000
            $table->bigInteger('time_key'); // id.jumlah_item.time()-1.678.420.000
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('username', 50); // username
            // $table->enum('tipe_pelanggan',['customer','guest']); // tipe_pelanggan sepertinya juga tidak diperlukan, selama pelanggan_id = null, maka customer belum terdaftar
            $table->foreignId('customer_id')->nullable()->constrained('users')->onDelete('set null'); // kalo data pelanggan dihapus, data transaksi yang udah dibuat tidak otomatis terhapus
            $table->string('nama_customer')->nullable();
            // $table->enum('guest_id',['A','B','C','D','E'])->nullable(); // guest_id tidak diperlukan di pembelian
            $table->string('keterangan')->nullable(); // jaga2 takutnya ada kondisi khusus yang ribet akhirnya perlu taro di keterangan
            $table->integer('harga_total');
            $table->integer('total_bayar');
            $table->integer('sisa_bayar');
            $table->string('status_bb', 20)->nullable(); // nullable untuk barang yang bukan perhiasan -> ['ada','bb-all','bb-sebagian']
            $table->string('status_bayar', 20); // ['lunas','belum-lunas']
            // $table->enum('status_terima_bb',['lunas','belum-lunas'])->nullable();
            $table->timestamp('tanggal_bb')->nullable(); // tanggal kapan terjual semua
            $table->foreignId('updated_by')->nullable()->constrained('users','id')->onDelete('set null');
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
