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
        Schema::table('carts', function (Blueprint $table) {
            $table->decimal('harga_total', 15, 2)->nullable()->change();
        });

        Schema::table('cart_items', function (Blueprint $table) {
            $table->decimal('harga_t', 15, 2)->change();
        });

        Schema::table('harga_pasarans', function (Blueprint $table) {
            $table->decimal('kadar', 8, 4)->change();
            $table->decimal('harga_beli', 15, 2)->change();
            $table->decimal('harga_buyback', 15, 2)->change();
        });

        Schema::table('items', function (Blueprint $table) {
            $table->decimal('kadar', 8, 4)->nullable()->change();
            $table->decimal('berat', 8, 4)->nullable()->change();
            $table->decimal('ongkos_g', 10, 2)->nullable()->change();
            $table->decimal('harga_g', 15, 2)->nullable()->change();
            $table->decimal('harga_t', 15, 2)->change();
        });

        Schema::table('kadars', function (Blueprint $table) {
            $table->decimal('kadar', 8, 4)->change();
        });

        Schema::table('surat_pembelians', function (Blueprint $table) {
            $table->decimal('harga_total', 15, 2)->change();
            $table->decimal('total_bayar', 15, 2)->change();
            $table->decimal('sisa_bayar', 12, 2)->change();
            $table->decimal('total_buyback', 15, 2)->nullable()->change();
        });

        Schema::table('surat_pembelian_items', function (Blueprint $table) {
            $table->decimal('kadar', 8, 4)->nullable()->change();
            $table->decimal('berat', 8, 4)->nullable()->change();
            $table->decimal('ongkos_g', 10, 2)->nullable()->change();
            $table->decimal('harga_g', 15, 2)->nullable()->change();
            $table->decimal('harga_t', 15, 2)->change();
            $table->decimal('berat_susut', 8, 4)->nullable()->change();
            $table->decimal('berat_buyback', 8, 4)->nullable()->change();
            $table->decimal('potongan_ongkos', 10, 2)->nullable()->change();
            $table->decimal('potongan_mata', 10, 2)->nullable()->change();
            $table->decimal('potongan_rusak', 10, 2)->nullable()->change();
            $table->decimal('potongan_susut', 10, 2)->nullable()->change();
            $table->decimal('potongan_lain', 10, 2)->nullable()->change();
            $table->decimal('total_potongan', 10, 2)->nullable()->change();
            $table->decimal('harga_buyback', 15, 2)->nullable()->change();
        });

        Schema::table('wallets', function (Blueprint $table) {
            $table->decimal('saldo', 15, 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->bigInteger('harga_total')->nullable()->change();
        });

        Schema::table('cart_items', function (Blueprint $table) {
            $table->bigInteger('harga_t')->change();
        });

        Schema::table('harga_pasarans', function (Blueprint $table) {
            $table->smallInteger('kadar')->change();
            $table->bigInteger('harga_beli')->change();
            $table->bigInteger('harga_buyback')->change();
        });

        Schema::table('items', function (Blueprint $table) {
            $table->smallInteger('kadar')->nullalbe()->change();
            $table->smallInteger('berat')->nullalbe()->change();
            $table->integer('ongkos_g')->nullalbe()->change();
            $table->bigInteger('harga_g')->nullalbe()->change();
            $table->bigInteger('harga_t')->change();
        });

        Schema::table('kadars', function (Blueprint $table) {
            $table->smallInteger('kadar')->change();
        });

        Schema::table('surat_pembelians', function (Blueprint $table) {
            $table->bigInteger('harga_total')->change();
            $table->bigInteger('total_bayar')->change();
            $table->bigInteger('sisa_bayar')->change();
            $table->bigInteger('total_buyback')->nullable()->change();
        });

        Schema::table('surat_pembelian_items', function (Blueprint $table) {
            $table->smallInteger('kadar')->nullable()->change();
            $table->smallInteger('berat')->nullable()->change();
            $table->integer('ongkos_g')->nullable()->change();
            $table->bigInteger('harga_g')->nullable()->change();
            $table->bigInteger('harga_t')->change();
            $table->smallInteger('berat_buyback')->nullable()->change();
            $table->integer('potongan_ongkos')->nullable()->change();
            $table->integer('potongan_mata')->nullable()->change();
            $table->integer('potongan_rusak')->nullable()->change();
            $table->integer('potongan_susut')->nullable()->change();
            $table->integer('potongan_lain')->nullable()->change();
            $table->integer('total_potongan')->nullable()->change();
            $table->bigInteger('harga_buyback')->nullable()->change();
        });

        Schema::table('wallets', function (Blueprint $table) {
            $table->bigInteger('saldo')->nullable()->change();
        });
    }
};
