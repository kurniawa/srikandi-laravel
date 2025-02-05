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
        Schema::create('surat_pembelian_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('surat_pembelian_id')->constrained()->onDelete('cascade');
            $table->foreignId('item_id')->nullable()->constrained()->onDelete('set null'); // nullable, karena nanti kalo ada item yang ga sengaja ke hapus, data ini tidak ikut terhapus
            $table->string('tipe_barang', 20);// ,['perhiasan','LM','lain-lain','bb-able','non-bb-able'] // campur -> tipe_barang bb_able dan non_bb_able
            $table->string('tipe_perhiasan',50)->nullable();
            $table->string('jenis_perhiasan')->nullable();
            $table->string('warna_emas',20)->nullable(); // kuning, rose-gold, putih, chrome
            $table->decimal('kadar', 8, 4)->nullable(); // nullable untuk barang yang bukan bb_able atau bukan perhiasan
            $table->decimal('berat', 8, 4)->nullable(); // nullable untuk barang yang bukan bb_able atau bukan perhiasan
            $table->decimal('ongkos_g', 10, 2)->nullable(); // nullable untuk barang yang bukan bb_able atau bukan perhiasan
            $table->decimal('harga_g', 15, 2)->nullable(); // nullable untuk barang yang bukan bb_able atau bukan perhiasan
            $table->decimal('harga_t', 15, 2);
            
            $table->string('shortname');
            $table->string('longname');
            $table->smallInteger('kondisi')->nullable(); // 99 => mulus, 80 => cacat dikit hampir tidak terlihat, 75 => cacat lumayan keliatan, 50 => rusak
            $table->string('cap',50)->nullable();
            $table->string('range_usia',20)->nullable(); // bayi, anak, remaja, dewasa
            $table->smallInteger('ukuran')->nullable(); // dalam mm, maks 9999mm berarti 99 cm, ga mungkin
            $table->string('merk',50)->nullable();
            $table->smallInteger('plat')->nullable(); // jumlah plat ya biasa 1 atau 2 atau 3
            $table->string('edisi',50)->nullable();
            $table->string('nampan',50)->nullable();
            $table->string('kode_item',100)->nullable(); // nullable dulu, soalnya belum tau mesti gimana formatnya
            $table->string('barcode')->nullable();
            $table->string('deskripsi')->nullable();
            $table->string('keterangan')->nullable();
            // $table->string('status', 20)->nullable(); // ready, terjual, cuci, dll
            $table->string('photo_path')->nullable();
            $table->smallInteger('jumlah')->default(1); // smallint    | 2 bytes  -32768 to 32767                              0 to 65535

            // Berikutnya adalah kolom yang berkaitan dengan penjualan
            // perlu diperhatikan disini banyak nullable, karena item belum tentu perhiasan yang bisa BB
            // $table->string('proses_bb', 20)->nullable(); // ['ready','finished'] // nullable untuk barang yang bukan bb_able atau bukan perhiasan
            // selama status_bb = ada, maka proses_bb akan tetap null, tidak berubah menjadi ready
            $table->string('locked_buyback', 10)->nullable(); // yes or no
            $table->string('status_buyback', 20)->nullable(); // ['ada','buyback', 'tukar', 'tukar-tambah', 'tukar-kurang'] // nullable untuk barang yang bukan bb_able atau bukan perhiasan
            $table->string('kondisi_buyback', 20)->nullable(); // ['sama', 'mulus','tidak-mulus', 'rusak-ringan', 'rusak-berat'] // nullable karena bisa jadi barang nya bukan perhiasan
            $table->enum('berat_susut', ['ya', 'tidak'])->nullable();
            $table->string('buyback_photo_path')->nullable();
            $table->decimal('berat_buyback', 8, 4)->nullable();
            $table->decimal('potongan_ongkos', 10, 2)->nullable();
            $table->decimal('potongan_mata', 10, 2)->nullable();
            $table->decimal('potongan_rusak', 10, 2)->nullable();
            $table->decimal('potongan_susut', 10, 2)->nullable();
            $table->decimal('potongan_lain', 10, 2)->nullable();
            $table->decimal('total_potongan', 10, 2)->nullable();
            $table->decimal('harga_buyback', 15, 2)->nullable();
            // $table->integer('total_bayar')->nullable();
            // $table->integer('sisa_bayar')->nullable();
            // $table->enum('status_bayar', ['lunas', 'belum-lunas'])->nullable();
            $table->string('keterangan_buyback')->nullable();
            $table->timestamps();
            $table->timestamp('tanggal_buyback')->nullable(); // bukan tanggal_jual, karena siapa tau barang ditukar
            // int/integer | 4 bytes  -2147483648 to 2147483647                    0 to 4294967295
            // smallint    | 2 bytes  -32768 to 32767                              0 to 65535
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_pembelian_items');
    }
};
