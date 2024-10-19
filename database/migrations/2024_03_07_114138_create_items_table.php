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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('tipe_barang',50);
            $table->string('tipe_perhiasan',50)->nullable();
            $table->string('jenis_perhiasan')->nullable();
            $table->string('warna_emas',20)->nullable(); // kuning, rose-gold, putih, chrome
            $table->smallInteger('kadar')->nullable();
            // $table->enum('gol_kadar',['MUDA','BAGUS','TUA'])->nullable();
            $table->smallInteger('berat')->nullable(); // int/integer | 4 bytes  -2147483648 to 2147483647                    0 to 4294967295
            $table->integer('ongkos_g')->nullable(); // nullable untuk barang yang bukan bb_able atau bukan perhiasan
            $table->bigInteger('harga_g')->nullable();
            $table->bigInteger('harga_t');
            $table->string('shortname');
            $table->string('longname')->nullable()->unique();
            $table->smallInteger('kondisi')->nullable(); // 99 => mulus, 80 => cacat dikit hampir tidak terlihat, 75 => cacat lumayan keliatan, 50 => rusak
            $table->string('cap',50)->nullable();
            $table->string('range_usia',20)->nullable(); // bayi, anak, remaja, dewasa
            $table->smallInteger('ukuran')->nullable(); // dalam mm, maks 9999mm berarti 99 cm, ga mungkin
            $table->string('merk',50)->nullable();
            $table->smallInteger('plat')->nullable(); // jumlah plat ya biasa 1 atau 2 atau 3
            $table->string('edisi',50)->nullable();
            $table->string('nampan',50)->nullable();
            $table->smallInteger('stock')->default('1'); // smallint    | 2 bytes  -32768 to 32767                              0 to 65535
            $table->string('kode_item',100)->nullable(); // nullable dulu, soalnya belum tau mesti gimana formatnya
            $table->integer('barcode')->nullable();
            $table->string('deskripsi')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('status', 20)->nullable(); // ready, terjual, cuci, sortir-buyback, dll
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
