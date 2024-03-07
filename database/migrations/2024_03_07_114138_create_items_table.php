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
            $table->string('range_usia',50)->nullable();
            $table->string('warna_emas',50)->nullable();
            $table->smallInteger('plat')->nullable();
            $table->string('cap',50)->nullable();
            $table->smallInteger('ukuran')->nullable();
            $table->string('nampan',50)->nullable();
            $table->string('merk',50)->nullable();
            $table->string('edisi',50)->nullable();
            $table->smallInteger('kadar')->nullable();
            $table->enum('gol_kadar',['MUDA','BAGUS','TUA'])->nullable();
            $table->smallInteger('berat')->nullable(); // int/integer | 4 bytes  -2147483648 to 2147483647                    0 to 4294967295
            $table->string('kondisi',50)->nullable();
            $table->string('nama_long');
            $table->string('nama_short');
            $table->smallInteger('stock')->default(1); // smallint    | 2 bytes  -32768 to 32767                              0 to 65535
            $table->string('kode_item',100);
            $table->integer('barcode')->nullable()->unique();
            $table->string('deskripsi')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('status', 20)->nullable(); // ada, terjual, cuci, dll
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
