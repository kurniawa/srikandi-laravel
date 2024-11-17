<?php

namespace Database\Seeders;

use App\Models\Accounting;
use App\Models\Cashflow;
use App\Models\SuratPembelian;
use App\Models\SuratPembelianItem;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionTest extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where("username", "kuruniawa")->first();
        $day = date('d');
        $month = date('m');
        $year = date('Y');

        $timekey = strtotime("$year-$month-$day 00:00:00");

        $surat_pembelians = [
            // BUYBACK
            [
                "tanggal_surat" => "2024-07-25 08:08:08",
                "nomor_surat" => uniqid(),
                "time_key" => "1721869688",
                "user_id" => $user->id,
                "username" => $user->username,
                "pelanggan_id" => null,
                "pelanggan_nama" => null,
                "pelanggan_username" => null,
                "pelanggan_nik" => null,
                "keterangan" => null,
                "harga_total" => "100000000",
                "total_bayar" => "100000000",
                "sisa_bayar" => "0",
                "status_buyback" => "all",
                "total_buyback" => "100000000",
                "status_bayar" => "lunas",
                "tanggal_buyback" => "2024-07-25 08:08:08",
                "updated_by" => null,
                "photo_path" => null,
                "created_at" => "2024-07-25 08:08:08",
                "updated_at" => "2024-07-25 08:08:08"
            ],
            [
                "tanggal_surat" => date("Y-m-d H:i:s", $timekey),
                "nomor_surat" => uniqid(),
                "time_key" => (string)$timekey,
                "user_id" => $user->id,
                "username" => $user->username,
                "pelanggan_id" => null,
                "pelanggan_nama" => null,
                "pelanggan_username" => null,
                "pelanggan_nik" => null,
                "keterangan" => null,
                "harga_total" => "60000000",
                "total_bayar" => "60000000",
                "sisa_bayar" => "0",
                "status_buyback" => "all",
                "total_buyback" => "60000000",
                "status_bayar" => "lunas",
                "tanggal_buyback" => date("Y-m-d H:i:s", $timekey),
                "updated_by" => null,
                "photo_path" => null,
                "created_at" => date("Y-m-d H:i:s", $timekey),
                "updated_at" => date("Y-m-d H:i:s", $timekey)
            ],
            [
                "tanggal_surat" => date("Y-m-d H:i:s", $timekey + 10000),
                "nomor_surat" => uniqid(),
                "time_key" => (string)($timekey + 10000),
                "user_id" => $user->id,
                "username" => $user->username,
                "pelanggan_id" => null,
                "pelanggan_nama" => null,
                "pelanggan_username" => null,
                "pelanggan_nik" => null,
                "keterangan" => null,
                "harga_total" => "60000000",
                "total_bayar" => "60000000",
                "sisa_bayar" => "0",
                "status_buyback" => "all",
                "total_buyback" => "60000000",
                "status_bayar" => "lunas",
                "tanggal_buyback" => date("Y-m-d H:i:s", $timekey + 10000),
                "updated_by" => null,
                "photo_path" => null,
                "created_at" => date("Y-m-d H:i:s", $timekey + 10000),
                "updated_at" => date("Y-m-d H:i:s", $timekey + 10000)
            ],
            [
                "tanggal_surat" => date("Y-m-d H:i:s", $timekey + 20000),
                "nomor_surat" => uniqid(),
                "time_key" => (string)($timekey + 20000),
                "user_id" => $user->id,
                "username" => $user->username,
                "pelanggan_id" => null,
                "pelanggan_nama" => null,
                "pelanggan_username" => null,
                "pelanggan_nik" => null,
                "keterangan" => null,
                "harga_total" => "100000000",
                "total_bayar" => "100000000",
                "sisa_bayar" => "0",
                "status_buyback" => "all",
                "total_buyback" => "100000000",
                "status_bayar" => "lunas",
                "tanggal_buyback" => date("Y-m-d H:i:s", $timekey + 20000),
                "updated_by" => null,
                "photo_path" => null,
                "created_at" => date("Y-m-d H:i:s", $timekey + 20000),
                "updated_at" => date("Y-m-d H:i:s", $timekey + 20000)
            ],
            // BUY
            [ // id:5
                "tanggal_surat" => "2024-07-25 08:08:08",
                "nomor_surat" => uniqid(),
                "time_key" => "1721869688",
                "user_id" => $user->id,
                "username" => $user->username,
                "pelanggan_id" => null,
                "pelanggan_nama" => null,
                "pelanggan_username" => null,
                "pelanggan_nik" => null,
                "keterangan" => null,
                "harga_total" => "100000000",
                "total_bayar" => "100000000",
                "sisa_bayar" => "0",
                "status_buyback" => null,
                "total_buyback" => null,
                "status_bayar" => "lunas",
                "tanggal_buyback" => null,
                "updated_by" => null,
                "photo_path" => null,
                "created_at" => "2024-07-25 08:08:08",
                "updated_at" => "2024-07-25 08:08:08"
            ],
            [ // id:6
                "tanggal_surat" => date("Y-m-d H:i:s", $timekey + 30000),
                "nomor_surat" => uniqid(),
                "time_key" => (string)($timekey + 30000),
                "user_id" => $user->id,
                "username" => $user->username,
                "pelanggan_id" => null,
                "pelanggan_nama" => null,
                "pelanggan_username" => null,
                "pelanggan_nik" => null,
                "keterangan" => null,
                "harga_total" => "60000000",
                "total_bayar" => "60000000",
                "sisa_bayar" => "0",
                "status_bayar" => "lunas",
                "status_buyback" => null,
                "total_buyback" => null,
                "tanggal_buyback" => null,
                "updated_by" => null,
                "photo_path" => null,
                "created_at" => date("Y-m-d H:i:s", $timekey + 30000),
                "updated_at" => date("Y-m-d H:i:s", $timekey + 30000)
            ],
            [ // id:7
                "tanggal_surat" => date("Y-m-d H:i:s", $timekey + 40000),
                "nomor_surat" => uniqid(),
                "time_key" => (string)($timekey + 40000),
                "user_id" => $user->id,
                "username" => $user->username,
                "pelanggan_id" => null,
                "pelanggan_nama" => null,
                "pelanggan_username" => null,
                "pelanggan_nik" => null,
                "keterangan" => null,
                "harga_total" => "60000000",
                "total_bayar" => "60000000",
                "sisa_bayar" => "0",
                "status_bayar" => "lunas",
                "status_buyback" => null,
                "total_buyback" => null,
                "tanggal_buyback" => null,
                "updated_by" => null,
                "photo_path" => null,
                "created_at" => date("Y-m-d H:i:s", $timekey + 40000),
                "updated_at" => date("Y-m-d H:i:s", $timekey + 40000)
            ],
            [ // id:8
                "tanggal_surat" => date("Y-m-d H:i:s", $timekey + 50000),
                "nomor_surat" => uniqid(),
                "time_key" => (string)($timekey + 50000),
                "user_id" => $user->id,
                "username" => $user->username,
                "pelanggan_id" => null,
                "pelanggan_nama" => null,
                "pelanggan_username" => null,
                "pelanggan_nik" => null,
                "keterangan" => null,
                "harga_total" => "100000000",
                "total_bayar" => "100000000",
                "sisa_bayar" => "0",
                "status_bayar" => "lunas",
                "status_buyback" => null,
                "total_buyback" => null,
                "tanggal_buyback" => null,
                "updated_by" => null,
                "photo_path" => null,
                "created_at" => date("Y-m-d H:i:s", $timekey + 50000),
                "updated_at" => date("Y-m-d H:i:s", $timekey + 50000)
            ]
        ];

        $surat_pembelian_items = [
            [
                "surat_pembelian_id" => 1,
                "item_id" => 5,
                "tipe_barang" => "perhiasan",
                "tipe_perhiasan" => "Anting",
                "jenis_perhiasan" => "Desi Polos",
                "warna_emas" => "kuning",
                "kadar" => "3750",
                "berat" => "2",
                "ongkos_g" => "2000000",
                "harga_g" => "100000000",
                "harga_t" => "100000000",
                "shortname" => "Anting Desi Polos 37.5% 2gr",
                "longname" => "Anting Desi Polos 37.5% 2gr ru:dewasa zu:9",
                "kondisi" => "9",
                "cap" => null,
                "range_usia" => "dewasa",
                "ukuran" => null,
                "merk" => null,
                "plat" => null,
                "edisi" => null,
                "nampan" => null,
                "kode_item" => null,
                "barcode" => null,
                "deskripsi" => null,
                "keterangan" => null,
                "photo_path" => null,
                "jumlah" => "1",
                "locked_buyback" => null,
                "status_buyback" => null,
                "kondisi_buyback" => null,
                "berat_susut" => null,
                "berat_buyback" => null,
                "buyback_photo_path" => null,
                "potongan_ongkos" => null,
                "potongan_mata" => null,
                "potongan_rusak" => null,
                "potongan_susut" => null,
                "potongan_lain" => null,
                "total_potongan" => null,
                "harga_buyback" => null,
                "keterangan_buyback" => null,
                "created_at" => "2024-07-25 08:08:08",
                "updated_at" => "2024-07-25 08:08:08",
                "tanggal_buyback" => "2024-07-25 08:08:08"
            ],
            [
                "surat_pembelian_id" => 2,
                "item_id" => 2,
                "tipe_barang" => "perhiasan",
                "tipe_perhiasan" => "Anting",
                "jenis_perhiasan" => "Desi Polos",
                "warna_emas" => "kuning",
                "kadar" => "3750",
                "berat" => "100",
                "ongkos_g" => "2000000",
                "harga_g" => "60000000",
                "harga_t" => "60000000",
                "shortname" => "Anting Desi Polos 37.5% 1gr",
                "longname" => "Anting Desi Polos 37.5% 1gr ru:dewasa zu:9",
                "kondisi" => "9",
                "cap" => null,
                "range_usia" => "dewasa",
                "ukuran" => null,
                "merk" => null,
                "plat" => null,
                "edisi" => null,
                "nampan" => null,
                "kode_item" => null,
                "barcode" => null,
                "deskripsi" => null,
                "keterangan" => null,
                "photo_path" => null,
                "jumlah" => "1",
                "locked_buyback" => null,
                "status_buyback" => null,
                "kondisi_buyback" => null,
                "berat_susut" => null,
                "berat_buyback" => null,
                "buyback_photo_path" => null,
                "potongan_ongkos" => null,
                "potongan_mata" => null,
                "potongan_rusak" => null,
                "potongan_susut" => null,
                "potongan_lain" => null,
                "total_potongan" => null,
                "harga_buyback" => null,
                "keterangan_buyback" => null,
                "created_at" => date("Y-m-d H:i:s", $timekey),
                "updated_at" => date("Y-m-d H:i:s", $timekey),
                "tanggal_buyback" => date("Y-m-d H:i:s", $timekey)
            ],
            [
                "surat_pembelian_id" => 2,
                "item_id" => 2,
                "tipe_barang" => "perhiasan",
                "tipe_perhiasan" => "Anting",
                "jenis_perhiasan" => "Desi Polos",
                "warna_emas" => "kuning",
                "kadar" => "3750",
                "berat" => "100",
                "ongkos_g" => "2000000",
                "harga_g" => "60000000",
                "harga_t" => "60000000",
                "shortname" => "Anting Desi Polos 37.5% 1gr",
                "longname" => "Anting Desi Polos 37.5% 1gr ru:dewasa zu:9",
                "kondisi" => "9",
                "cap" => null,
                "range_usia" => "dewasa",
                "ukuran" => null,
                "merk" => null,
                "plat" => null,
                "edisi" => null,
                "nampan" => null,
                "kode_item" => null,
                "barcode" => null,
                "deskripsi" => null,
                "keterangan" => null,
                "photo_path" => null,
                "jumlah" => "1",
                "locked_buyback" => null,
                "status_buyback" => null,
                "kondisi_buyback" => null,
                "berat_susut" => null,
                "berat_buyback" => null,
                "buyback_photo_path" => null,
                "potongan_ongkos" => null,
                "potongan_mata" => null,
                "potongan_rusak" => null,
                "potongan_susut" => null,
                "potongan_lain" => null,
                "total_potongan" => null,
                "harga_buyback" => null,
                "keterangan_buyback" => null,
                "created_at" => date("Y-m-d H:i:s", $timekey+10000),
                "updated_at" => date("Y-m-d H:i:s", $timekey+10000),
                "tanggal_buyback" => date("Y-m-d H:i:s", $timekey+10000)
            ],
            [
                "surat_pembelian_id" => 3,
                "item_id" => 3,
                "tipe_barang" => "perhiasan",
                "tipe_perhiasan" => "Anting",
                "jenis_perhiasan" => "Desi Polos",
                "warna_emas" => "kuning",
                "kadar" => "7000",
                "berat" => "100",
                "ongkos_g" => "5000000",
                "harga_g" => "100000000",
                "harga_t" => "100000000",
                "shortname" => "Anting Desi Polos 70% 1gr",
                "longname" => "Anting Desi Polos 70% 1gr ru:dewasa zu:9",
                "kondisi" => "9",
                "cap" => null,
                "range_usia" => "dewasa",
                "ukuran" => null,
                "merk" => null,
                "plat" => null,
                "edisi" => null,
                "nampan" => null,
                "kode_item" => null,
                "barcode" => null,
                "deskripsi" => null,
                "keterangan" => null,
                "photo_path" => null,
                "jumlah" => "1",
                "locked_buyback" => null,
                "status_buyback" => null,
                "kondisi_buyback" => null,
                "berat_susut" => null,
                "berat_buyback" => null,
                "buyback_photo_path" => null,
                "potongan_ongkos" => null,
                "potongan_mata" => null,
                "potongan_rusak" => null,
                "potongan_susut" => null,
                "potongan_lain" => null,
                "total_potongan" => null,
                "harga_buyback" => null,
                "keterangan_buyback" => null,
                "created_at" => date("Y-m-d H:i:s", $timekey+20000),
                "updated_at" => date("Y-m-d H:i:s", $timekey+20000),
                "tanggal_buyback" => date("Y-m-d H:i:s", $timekey+20000)
            ],
            // BUY
            [
                "surat_pembelian_id" => 5,
                "item_id" => 5,
                "tipe_barang" => "perhiasan",
                "tipe_perhiasan" => "Anting",
                "jenis_perhiasan" => "Desi Polos",
                "warna_emas" => "kuning",
                "kadar" => "3750",
                "berat" => "2",
                "ongkos_g" => "2000000",
                "harga_g" => "100000000",
                "harga_t" => "100000000",
                "shortname" => "Anting Desi Polos 37.5% 2gr",
                "longname" => "Anting Desi Polos 37.5% 2gr ru:dewasa zu:9",
                "kondisi" => "9",
                "cap" => null,
                "range_usia" => "dewasa",
                "ukuran" => null,
                "merk" => null,
                "plat" => null,
                "edisi" => null,
                "nampan" => null,
                "kode_item" => null,
                "barcode" => null,
                "deskripsi" => null,
                "keterangan" => null,
                "photo_path" => null,
                "jumlah" => "1",
                "locked_buyback" => null,
                "status_buyback" => null,
                "kondisi_buyback" => null,
                "berat_susut" => null,
                "berat_buyback" => null,
                "buyback_photo_path" => null,
                "potongan_ongkos" => null,
                "potongan_mata" => null,
                "potongan_rusak" => null,
                "potongan_susut" => null,
                "potongan_lain" => null,
                "total_potongan" => null,
                "harga_buyback" => null,
                "keterangan_buyback" => null,
                "created_at" => "2024-07-25 08:08:08",
                "updated_at" => "2024-07-25 08:08:08",
                "tanggal_buyback" => "2024-07-25 08:08:08"
            ],
            [
                "surat_pembelian_id" => 6,
                "item_id" => 2,
                "tipe_barang" => "perhiasan",
                "tipe_perhiasan" => "Anting",
                "jenis_perhiasan" => "Desi Polos",
                "warna_emas" => "kuning",
                "kadar" => "3750",
                "berat" => "100",
                "ongkos_g" => "2000000",
                "harga_g" => "60000000",
                "harga_t" => "60000000",
                "shortname" => "Anting Desi Polos 37.5% 1gr",
                "longname" => "Anting Desi Polos 37.5% 1gr ru:dewasa zu:9",
                "kondisi" => "9",
                "cap" => null,
                "range_usia" => "dewasa",
                "ukuran" => null,
                "merk" => null,
                "plat" => null,
                "edisi" => null,
                "nampan" => null,
                "kode_item" => null,
                "barcode" => null,
                "deskripsi" => null,
                "keterangan" => null,
                "photo_path" => null,
                "jumlah" => "1",
                "locked_buyback" => null,
                "status_buyback" => null,
                "kondisi_buyback" => null,
                "berat_susut" => null,
                "berat_buyback" => null,
                "buyback_photo_path" => null,
                "potongan_ongkos" => null,
                "potongan_mata" => null,
                "potongan_rusak" => null,
                "potongan_susut" => null,
                "potongan_lain" => null,
                "total_potongan" => null,
                "harga_buyback" => null,
                "keterangan_buyback" => null,
                "created_at" => date("Y-m-d H:i:s", $timekey + 30000),
                "updated_at" => date("Y-m-d H:i:s", $timekey + 30000),
                "tanggal_buyback" => date("Y-m-d H:i:s", $timekey + 30000)
            ],
            [
                "surat_pembelian_id" => 7,
                "item_id" => 2,
                "tipe_barang" => "perhiasan",
                "tipe_perhiasan" => "Anting",
                "jenis_perhiasan" => "Desi Polos",
                "warna_emas" => "kuning",
                "kadar" => "3750",
                "berat" => "100",
                "ongkos_g" => "2000000",
                "harga_g" => "60000000",
                "harga_t" => "60000000",
                "shortname" => "Anting Desi Polos 37.5% 1gr",
                "longname" => "Anting Desi Polos 37.5% 1gr ru:dewasa zu:9",
                "kondisi" => "9",
                "cap" => null,
                "range_usia" => "dewasa",
                "ukuran" => null,
                "merk" => null,
                "plat" => null,
                "edisi" => null,
                "nampan" => null,
                "kode_item" => null,
                "barcode" => null,
                "deskripsi" => null,
                "keterangan" => null,
                "photo_path" => null,
                "jumlah" => "1",
                "locked_buyback" => null,
                "status_buyback" => null,
                "kondisi_buyback" => null,
                "berat_susut" => null,
                "berat_buyback" => null,
                "buyback_photo_path" => null,
                "potongan_ongkos" => null,
                "potongan_mata" => null,
                "potongan_rusak" => null,
                "potongan_susut" => null,
                "potongan_lain" => null,
                "total_potongan" => null,
                "harga_buyback" => null,
                "keterangan_buyback" => null,
                "created_at" => date("Y-m-d H:i:s", $timekey + 40000),
                "updated_at" => date("Y-m-d H:i:s", $timekey + 40000),
                "tanggal_buyback" => date("Y-m-d H:i:s", $timekey + 40000)
            ],
            [
                "surat_pembelian_id" => 8,
                "item_id" => 3,
                "tipe_barang" => "perhiasan",
                "tipe_perhiasan" => "Anting",
                "jenis_perhiasan" => "Desi Polos",
                "warna_emas" => "kuning",
                "kadar" => "7000",
                "berat" => "100",
                "ongkos_g" => "5000000",
                "harga_g" => "100000000",
                "harga_t" => "100000000",
                "shortname" => "Anting Desi Polos 70% 1gr",
                "longname" => "Anting Desi Polos 70% 1gr ru:dewasa zu:9",
                "kondisi" => "9",
                "cap" => null,
                "range_usia" => "dewasa",
                "ukuran" => null,
                "merk" => null,
                "plat" => null,
                "edisi" => null,
                "nampan" => null,
                "kode_item" => null,
                "barcode" => null,
                "deskripsi" => null,
                "keterangan" => null,
                "photo_path" => null,
                "jumlah" => "1",
                "locked_buyback" => null,
                "status_buyback" => null,
                "kondisi_buyback" => null,
                "berat_susut" => null,
                "berat_buyback" => null,
                "buyback_photo_path" => null,
                "potongan_ongkos" => null,
                "potongan_mata" => null,
                "potongan_rusak" => null,
                "potongan_susut" => null,
                "potongan_lain" => null,
                "total_potongan" => null,
                "harga_buyback" => null,
                "keterangan_buyback" => null,
                "created_at" => date("Y-m-d H:i:s", $timekey + 50000),
                "updated_at" => date("Y-m-d H:i:s", $timekey + 50000),
                "tanggal_buyback" => date("Y-m-d H:i:s", $timekey + 50000)
            ]
        ];

        $accountings = [
            [
                "kode_accounting" => "$user->id.1721869688",
                "surat_pembelian_id" => 1,
                "surat_pembelian_item_id" => 1,
                "nama_barang" => "Anting Desi Polos 37.5% 2gr ru:dewasa zu:9",
                "kadar" => "3750",
                "berat" => "200",
                "user_id" => $user->id,
                "supplier_id" => null,
                "supplier_name" => null,
                "tipe" => "pengeluaran",
                "kategori" => "Buyback Perhiasan",
                "kategori_2" => null,
                "deskripsi" => null,
                "jumlah" => "100000000",
                "created_at" => date("Y-m-d H:i:s", 1721869688),
                "updated_at" => date("Y-m-d H:i:s", 1721869688)
            ],
            [
                "kode_accounting" => "$user->id.$timekey",
                "surat_pembelian_id" => 2,
                "surat_pembelian_item_id" => 2,
                "nama_barang" => "Anting Desi Polos 37.5% 1gr ru:dewasa zu:9",
                "kadar" => "3750",
                "berat" => "100",
                "user_id" => $user->id,
                "supplier_id" => null,
                "supplier_name" => null,
                "tipe" => "pengeluaran",
                "kategori" => "Buyback Perhiasan",
                "kategori_2" => null,
                "deskripsi" => null,
                "jumlah" => "60000000",
                "created_at" => date("Y-m-d H:i:s", $timekey),
                "updated_at" => date("Y-m-d H:i:s", $timekey)
            ],
            [
                "kode_accounting" => "$user->id." . $timekey + 10000,
                "surat_pembelian_id" => 2,
                "surat_pembelian_item_id" => 3,
                "nama_barang" => "Anting Desi Polos 37.5% 1gr ru:dewasa zu:9",
                "kadar" => "3750",
                "berat" => "100",
                "user_id" => $user->id,
                "supplier_id" => null,
                "supplier_name" => null,
                "tipe" => "pengeluaran",
                "kategori" => "Buyback Perhiasan",
                "kategori_2" => null,
                "deskripsi" => null,
                "jumlah" => "60000000",
                "created_at" => date("Y-m-d H:i:s", $timekey + 10000),
                "updated_at" => date("Y-m-d H:i:s", $timekey + 10000)
            ],
            [
                "kode_accounting" => "$user->id." . $timekey + 20000,
                "surat_pembelian_id" => 3,
                "surat_pembelian_item_id" => 4,
                "nama_barang" => "Anting Desi Polos 70% 1gr ru:dewasa zu:9",
                "kadar" => "7000",
                "berat" => "100",
                "user_id" => $user->id,
                "supplier_id" => null,
                "supplier_name" => null,
                "tipe" => "pengeluaran",
                "kategori" => "Buyback Perhiasan",
                "kategori_2" => null,
                "deskripsi" => null,
                "jumlah" => "100000000",
                "created_at" => date("Y-m-d H:i:s", $timekey + 20000),
                "updated_at" => date("Y-m-d H:i:s", $timekey + 20000)
            ],
            // BUY
            [
                "kode_accounting" => "$user->id.1721869688",
                "surat_pembelian_id" => 5,
                "surat_pembelian_item_id" => 1,
                "nama_barang" => "Anting Desi Polos 37.5% 2gr ru:dewasa zu:9",
                "kadar" => "3750",
                "berat" => "200",
                "user_id" => $user->id,
                "supplier_id" => null,
                "supplier_name" => null,
                "tipe" => "pemasukan",
                "kategori" => "Penjualan Produk",
                "kategori_2" => "Penjualan Perhiasan",
                "deskripsi" => null,
                "jumlah" => "100000000",
                "created_at" => date("Y-m-d H:i:s", 1721869688),
                "updated_at" => date("Y-m-d H:i:s", 1721869688)
            ],
            [
                "kode_accounting" => "$user->id.$timekey",
                "surat_pembelian_id" => 6,
                "surat_pembelian_item_id" => 2,
                "nama_barang" => "Anting Desi Polos 37.5% 1gr ru:dewasa zu:9",
                "kadar" => "3750",
                "berat" => "100",
                "user_id" => $user->id,
                "supplier_id" => null,
                "supplier_name" => null,
                "tipe" => "pemasukan",
                "kategori" => "Penjualan Produk",
                "kategori_2" => "Penjualan Perhiasan",
                "deskripsi" => null,
                "jumlah" => "60000000",
                "created_at" => date("Y-m-d H:i:s", $timekey + 30000),
                "updated_at" => date("Y-m-d H:i:s", $timekey + 30000)
            ],
            [
                "kode_accounting" => "$user->id." . $timekey + 10000,
                "surat_pembelian_id" => 7,
                "surat_pembelian_item_id" => 3,
                "nama_barang" => "Anting Desi Polos 37.5% 1gr ru:dewasa zu:9",
                "kadar" => "3750",
                "berat" => "100",
                "user_id" => $user->id,
                "supplier_id" => null,
                "supplier_name" => null,
                "tipe" => "pemasukan",
                "kategori" => "Penjualan Produk",
                "kategori_2" => "Penjualan Perhiasan",
                "deskripsi" => null,
                "jumlah" => "60000000",
                "created_at" => date("Y-m-d H:i:s", $timekey + 40000),
                "updated_at" => date("Y-m-d H:i:s", $timekey + 40000)
            ],
            [
                "kode_accounting" => "$user->id." . $timekey + 20000,
                "surat_pembelian_id" => 8,
                "surat_pembelian_item_id" => 4,
                "nama_barang" => "Anting Desi Polos 70% 1gr ru:dewasa zu:9",
                "kadar" => "7000",
                "berat" => "100",
                "user_id" => $user->id,
                "supplier_id" => null,
                "supplier_name" => null,
                "tipe" => "pemasukan",
                "kategori" => "Penjualan Produk",
                "kategori_2" => "Penjualan Perhiasan",
                "deskripsi" => null,
                "jumlah" => "100000000",
                "created_at" => date("Y-m-d H:i:s", $timekey + 50000),
                "updated_at" => date("Y-m-d H:i:s", $timekey + 50000)
            ]
        ];

        $cashflows = [
            [
                "user_id" => $user->id,
                "time_key" => "1721869688",
                "kode_accounting" => "$user->id.1721869688",
                "surat_pembelian_id" => 1,
                "tipe" => "pengeluaran",
                "kategori_wallet" => "tunai",
                "tipe_wallet" => "laci",
                "nama_wallet" => "cash",
                "jumlah" => "10000000",
                "saldo" => "0",
                "keterangan" => null,
                "created_at" => date("Y-m-d H:i:s", 1721869688),
                "updated_at" => date("Y-m-d H:i:s", 1721869688)
            ],
            [
                "user_id" => $user->id,
                "time_key" => (string)($timekey+10000),
                "kode_accounting" => "$user->id." . $timekey + 10000,
                "surat_pembelian_id" => 2,
                "tipe" => "pengeluaran",
                "kategori_wallet" => "tunai",
                "tipe_wallet" => "laci",
                "nama_wallet" => "cash",
                "jumlah" => "60000000",
                "saldo" => "0",
                "keterangan" => null,
                "created_at" => date("Y-m-d H:i:s", $timekey),
                "updated_at" => date("Y-m-d H:i:s", $timekey)
            ],
            [
                "user_id" => $user->id,
                "time_key" => $timekey,
                "kode_accounting" => "$user->id.$timekey",
                "surat_pembelian_id" => 2,
                "tipe" => "pengeluaran",
                "kategori_wallet" => "tunai",
                "tipe_wallet" => "laci",
                "nama_wallet" => "cash",
                "jumlah" => "60000000",
                "saldo" => "0",
                "keterangan" => null,
                "created_at" => date("Y-m-d H:i:s", $timekey + 10000),
                "updated_at" => date("Y-m-d H:i:s", $timekey + 10000)
            ],
            [
                "user_id" => $user->id,
                "time_key" => $timekey,
                "kode_accounting" => "$user->id.$timekey",
                "surat_pembelian_id" => 3,
                "tipe" => "pengeluaran",
                "kategori_wallet" => "non-tunai",
                "tipe_wallet" => "bank",
                "nama_wallet" => "BCA",
                "jumlah" => "100000000",
                "saldo" => "0",
                "keterangan" => null,
                "created_at" => date("Y-m-d H:i:s", $timekey + 10000),
                "updated_at" => date("Y-m-d H:i:s", $timekey + 10000)
            ],
            // BUY
            [
                "user_id" => $user->id,
                "time_key" => "1721869688",
                "kode_accounting" => "$user->id.1721869688",
                "surat_pembelian_id" => 5,
                "tipe" => "pemasukan",
                "kategori_wallet" => "tunai",
                "tipe_wallet" => "laci",
                "nama_wallet" => "cash",
                "jumlah" => "10000000",
                "saldo" => "0",
                "keterangan" => null,
                "created_at" => date("Y-m-d H:i:s", 1721869688),
                "updated_at" => date("Y-m-d H:i:s", 1721869688)
            ],
            [
                "user_id" => $user->id,
                "time_key" => (string)($timekey+30000),
                "kode_accounting" => "$user->id." . $timekey + 30000,
                "surat_pembelian_id" => 6,
                "tipe" => "pemasukan",
                "kategori_wallet" => "tunai",
                "tipe_wallet" => "laci",
                "nama_wallet" => "cash",
                "jumlah" => "60000000",
                "saldo" => "0",
                "keterangan" => null,
                "created_at" => date("Y-m-d H:i:s", $timekey + 30000),
                "updated_at" => date("Y-m-d H:i:s", $timekey + 30000)
            ],
            [
                "user_id" => $user->id,
                "time_key" => (string)($timekey + 40000),
                "kode_accounting" => "$user->id." . $timekey + 40000,
                "surat_pembelian_id" => 7,
                "tipe" => "pemasukan",
                "kategori_wallet" => "tunai",
                "tipe_wallet" => "laci",
                "nama_wallet" => "cash",
                "jumlah" => "60000000",
                "saldo" => "0",
                "keterangan" => null,
                "created_at" => date("Y-m-d H:i:s", $timekey + 40000),
                "updated_at" => date("Y-m-d H:i:s", $timekey + 40000)
            ],
            [
                "user_id" => $user->id,
                "time_key" => (string)($timekey + 50000),
                "kode_accounting" => "$user->id." . $timekey + 50000,
                "surat_pembelian_id" => 8,
                "tipe" => "pemasukan",
                "kategori_wallet" => "non-tunai",
                "tipe_wallet" => "bank",
                "nama_wallet" => "BCA",
                "jumlah" => "100000000",
                "saldo" => "0",
                "keterangan" => null,
                "created_at" => date("Y-m-d H:i:s", $timekey + 50000),
                "updated_at" => date("Y-m-d H:i:s", $timekey + 50000)
            ]
        ];

        for ($i=0; $i < count($surat_pembelians); $i++) { 
            SuratPembelian::create($surat_pembelians[$i]);
            SuratPembelianItem::create($surat_pembelian_items[$i]);
            Accounting::create($accountings[$i]);
            $last_saldo = Cashflow::select('saldo')->where('tipe_wallet', $cashflows[$i]['tipe_wallet'])->where('tipe_wallet', $cashflows[$i]['tipe_wallet'])->where('nama_wallet', $cashflows[$i]['nama_wallet'])->latest()->first();
            if ($last_saldo) {
                $last_saldo = (int)$last_saldo->saldo;
            } else {
                $last_saldo = 0;
            }

            $updated_saldo = 0;
            if ($cashflows[$i]['tipe'] == 'pengeluaran') {
                $updated_saldo = $last_saldo - (int)$cashflows[$i]['jumlah'];
            } else {
                $updated_saldo = $last_saldo + (int)$cashflows[$i]['jumlah'];
            }
            $cashflow = Cashflow::create($cashflows[$i]);
            $cashflow->saldo = $updated_saldo;
            $cashflow->save();
            // dump($cashflow);
            $wallet = Wallet::where('nama_wallet', $cashflow->nama_wallet)->first();
            $wallet->saldo = $cashflow->saldo;
            $wallet->save();
        }
    }
}
