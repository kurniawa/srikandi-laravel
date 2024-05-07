<?php

namespace Database\Seeders;

use App\Models\Wallet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $wallets = [
            ['kategori'=>'tunai', 'tipe'=>'laci', 'nama'=>'cash'],
            ['kategori'=>'non-tunai', 'tipe'=>'bank', 'nama'=>'BCA'],
            ['kategori'=>'non-tunai', 'tipe'=>'bank', 'nama'=>'BRI'],
            ['kategori'=>'non-tunai', 'tipe'=>'bank', 'nama'=>'Mandiri'],
            ['kategori'=>'non-tunai', 'tipe'=>'bank', 'nama'=>'BNI'],
            ['kategori'=>'non-tunai', 'tipe'=>'bank', 'nama'=>'CIMB'],
            ['kategori'=>'non-tunai', 'tipe'=>'bank', 'nama'=>'OCBC'],
            ['kategori'=>'non-tunai', 'tipe'=>'bank', 'nama'=>'BJB'],
            ['kategori'=>'non-tunai', 'tipe'=>'bank', 'nama'=>'Maybank'],
            ['kategori'=>'non-tunai', 'tipe'=>'ewallet', 'nama'=>'GoPay'],
            ['kategori'=>'non-tunai', 'tipe'=>'ewallet', 'nama'=>'ShopeePay'],
            ['kategori'=>'non-tunai', 'tipe'=>'ewallet', 'nama'=>'Dana'],
            ['kategori'=>'non-tunai', 'tipe'=>'ewallet', 'nama'=>'OVO'],
        ];

        foreach ($wallets as $wallet) {
            Wallet::create([
                "kategori" => $wallet['kategori'],
                "tipe" => $wallet['tipe'],
                "nama" => $wallet['nama'],
            ]);
        }
    }
}
