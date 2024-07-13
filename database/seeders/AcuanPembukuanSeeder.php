<?php

namespace Database\Seeders;

use App\Models\AcuanPembukuan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AcuanPembukuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $acuan_pembukuans = [
            ['tipe' => 'pemasukan', 'kategori' => 'Penjualan Produk', 'kategori_2' => 'Penjualan Perhiasan'],
            ['tipe' => 'pemasukan', 'kategori' => 'Penjualan Produk', 'kategori_2' => 'Penjualan LM'],
            ['tipe' => 'pemasukan', 'kategori' => 'Penjualan Produk', 'kategori_2' => 'Penjualan Kotak Perhiasan'],
            ['tipe' => 'pemasukan', 'kategori' => 'Mutasi'],
            ['tipe' => 'pemasukan', 'kategori' => 'Penyesuaian Saldo'],
            ['tipe' => 'pemasukan', 'kategori' => 'Lain-Lain'],
            // PENGELUARAN
            ['tipe' => 'pengeluaran', 'kategori' => 'Buyback Perhiasan'], // Buyback tanpa surat disertai dengan surat pernyataan dan foto KTP dan foto Transaksi
            // Buyback dari toko lain disertai dengan foto transaksi dan foto KTP
            // Disertai dengan data user_id, kadar, berat, nama barang, harga_buyback
            ['tipe' => 'pengeluaran', 'kategori' => 'Biaya Produksi', 'kategori_2' => 'Ongkos Cuci'],
            // Disertai dengan data tukang cuci, kadar, berat dan biaya/ongkos cuci
            ['tipe' => 'pengeluaran', 'kategori' => 'Pembayaran Hutang', 'kategori_2' => 'Pembelian Aset'],
            // Disertai dengan data supplier
            ['tipe' => 'pengeluaran', 'kategori' => 'Pembelian Aset', 'kategori_2' => 'Pembelian Perhiasan'],
            ['tipe' => 'pengeluaran', 'kategori' => 'Pembelian Aset', 'kategori_2' => 'Pembelian LM'],
            ['tipe' => 'pengeluaran', 'kategori' => 'Pembayaran Gaji Karyawan'],
            ['tipe' => 'pengeluaran', 'kategori' => 'Tunjangan Karyawan', 'kategori_2' => 'Uang Makan'],
            ['tipe' => 'pengeluaran', 'kategori' => 'Tunjangan Karyawan', 'kategori_2' => 'Uang Transport'],
            ['tipe' => 'pengeluaran', 'kategori' => 'Tunjangan Karyawan', 'kategori_2' => 'Tunjangan Kesehatan'],
            ['tipe' => 'pengeluaran', 'kategori' => 'Pembayaran Tagihan', 'kategori_2' => 'Listrik'],
            ['tipe' => 'pengeluaran', 'kategori' => 'Pembayaran Tagihan', 'kategori_2' => 'Air'],
            ['tipe' => 'pengeluaran', 'kategori' => 'Pembayaran Tagihan', 'kategori_2' => 'Internet'],
            ['tipe' => 'pengeluaran', 'kategori' => 'Pembayaran Tagihan', 'kategori_2' => 'Keamanan'],
            ['tipe' => 'pengeluaran', 'kategori' => 'Pembayaran Tagihan', 'kategori_2' => 'Kebersihan'],
            ['tipe' => 'pengeluaran', 'kategori' => 'Inventaris Kantor'],
            ['tipe' => 'pengeluaran', 'kategori' => 'Pembayaran Pajak'],
            ['tipe' => 'pengeluaran', 'kategori' => 'Mutasi'],
            ['tipe' => 'pengeluaran', 'kategori' => 'Penyesuaian Saldo'],
            ['tipe' => 'pengeluaran', 'kategori' => 'Lain-Lain'],
        ];

        foreach ($acuan_pembukuans as $acuan_pembukuan) {
            $kategori_2 = null;
            if (isset($acuan_pembukuan['kategori_2'])) {
                $kategori_2 = $acuan_pembukuan['kategori_2'];
            }
            AcuanPembukuan::create([
                'tipe' => $acuan_pembukuan['tipe'],
                'kategori' => $acuan_pembukuan['kategori'],
                'kategori_2' => $kategori_2,
            ]);
        }
    }
}
