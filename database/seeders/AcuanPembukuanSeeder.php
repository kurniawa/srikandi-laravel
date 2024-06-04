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
            ['tipe'=>'pemasukan', 'kategori'=>'Penjualan Barang', 'kategori_2'=>'Penjualan Perhiasan'],
            ['tipe'=>'pemasukan', 'kategori'=>'Penjualan Barang', 'kategori_2'=>'Penjualan LM'],
            ['tipe'=>'pemasukan', 'kategori'=>'Penjualan Barang', 'kategori_2'=>'Penjualan Kotak Perhiasan'],
            ['tipe'=>'pemasukan', 'kategori'=>'Mutasi'],
            // PENGELUARAN
            ['tipe'=>'pengeluaran', 'kategori'=>'Buyback Perhiasan'],
            ['tipe'=>'pengeluaran', 'kategori'=>'Buyback LM'],
            ['tipe'=>'pengeluaran', 'kategori'=>'Pembelian Aset', 'kategori_2'=>'Pembelian Perhiasan'],
            ['tipe'=>'pengeluaran', 'kategori'=>'Pembelian Aset', 'kategori_2'=>'Pembelian LM'],
            ['tipe'=>'pengeluaran', 'kategori'=>'Pembayaran Gaji Karyawan'],
            ['tipe'=>'pengeluaran', 'kategori'=>'Tunjangan Karyawan', 'kategori_2'=>'Uang Makan'],
            ['tipe'=>'pengeluaran', 'kategori'=>'Tunjangan Karyawan', 'kategori_2'=>'Uang Transport'],
            ['tipe'=>'pengeluaran', 'kategori'=>'Tunjangan Karyawan', 'kategori_2'=>'Tunjangan Kesehatan'],
            ['tipe'=>'pengeluaran', 'kategori'=>'Pembayaran Tagihan', 'kategori_2'=>'Listrik'],
            ['tipe'=>'pengeluaran', 'kategori'=>'Pembayaran Tagihan', 'kategori_2'=>'Air'],
            ['tipe'=>'pengeluaran', 'kategori'=>'Inventaris Kantor'],
            ['tipe'=>'pengeluaran', 'kategori'=>'Pembayaran Pajak'],
            ['tipe'=>'pengeluaran', 'kategori'=>'Mutasi'],
        ];

        foreach ($acuan_pembukuans as $acuan_pembukuan) {
            $kategori_2 = null;
            if (isset($acuan_pembukuan['kategori_2'])) {
                $kategori_2 = $acuan_pembukuan['kategori_2'];
            }
            AcuanPembukuan::create([
                'tipe'=>$acuan_pembukuan['tipe'],
                'kategori'=>$acuan_pembukuan['kategori'],
                'kategori_2'=>$kategori_2,
            ]);
        }
    }
}
