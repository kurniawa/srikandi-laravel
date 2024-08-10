<?php

namespace Database\Seeders;

use App\Models\Accounting;
use App\Models\Cashflow;
use App\Models\SuratPembelian;
use App\Models\SuratPembelianItem;
use App\Models\User;
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
            ]
        ];

        $surat_pembelian_items = [
            [
                "surat_pembelian_id" => 1,
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
            ]
        ];

        $accountings = [
            [
                "kode_accounting" => "$user->id.$timekey",
                "surat_pembelian_id" => 1,
                "surat_pembelian_item_id" => 1,
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
                "created_at" => date("Y-m-d H:i:s", $timekey + 10000),
                "updated_at" => date("Y-m-d H:i:s", $timekey + 10000)
            ],
            [
                "kode_accounting" => "$user->id." . $timekey + 20000,
                "surat_pembelian_id" => 3,
                "surat_pembelian_item_id" => 3,
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
            ]
        ];

        $cashflows = [
            [
                "user_id" => $user->id,
                "time_key" => (string)($timekey+10000),
                "kode_accounting" => "$user->id." . $timekey + 10000,
                "surat_pembelian_id" => 1,
                "tipe" => "pengeluaran",
                "kategori_wallet" => "tunai",
                "tipe_wallet" => "laci",
                "nama_wallet" => "cash",
                "jumlah" => "60000000",
                "saldo" => "-60000000",
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
                "saldo" => "-120000000",
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
                "nama_wallet" => "bca",
                "jumlah" => "100000000",
                "saldo" => "-100000000",
                "keterangan" => null,
                "created_at" => date("Y-m-d H:i:s", $timekey + 10000),
                "updated_at" => date("Y-m-d H:i:s", $timekey + 10000)
            ]
        ];

        for ($i=0; $i < count($surat_pembelians); $i++) { 
            SuratPembelian::create($surat_pembelians[$i]);
            SuratPembelianItem::create($surat_pembelian_items[$i]);
            Accounting::create($accountings[$i]);
            Cashflow::create($cashflows[$i]);
        }
    }
}
