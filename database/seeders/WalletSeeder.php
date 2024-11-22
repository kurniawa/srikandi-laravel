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
            ['kategori_wallet'=>'tunai', 'tipe_wallet'=>'laci', 'nama_wallet'=>'cash'],
            ['kategori_wallet'=>'non-tunai', 'tipe_wallet'=>'bank', 'nama_wallet'=>'BCA'],
            ['kategori_wallet'=>'non-tunai', 'tipe_wallet'=>'bank', 'nama_wallet'=>'BRI'],
            ['kategori_wallet'=>'non-tunai', 'tipe_wallet'=>'bank', 'nama_wallet'=>'Mandiri'],
            ['kategori_wallet'=>'non-tunai', 'tipe_wallet'=>'bank', 'nama_wallet'=>'BNI'],
            ['kategori_wallet'=>'non-tunai', 'tipe_wallet'=>'bank', 'nama_wallet'=>'CIMB'],
            ['kategori_wallet'=>'non-tunai', 'tipe_wallet'=>'bank', 'nama_wallet'=>'OCBC'],
            ['kategori_wallet'=>'non-tunai', 'tipe_wallet'=>'bank', 'nama_wallet'=>'BJB'],
            ['kategori_wallet'=>'non-tunai', 'tipe_wallet'=>'bank', 'nama_wallet'=>'Maybank'],
            ['kategori_wallet'=>'non-tunai', 'tipe_wallet'=>'ewallet', 'nama_wallet'=>'GoPay'],
            ['kategori_wallet'=>'non-tunai', 'tipe_wallet'=>'ewallet', 'nama_wallet'=>'ShopeePay'],
            ['kategori_wallet'=>'non-tunai', 'tipe_wallet'=>'ewallet', 'nama_wallet'=>'Dana'],
            ['kategori_wallet'=>'non-tunai', 'tipe_wallet'=>'ewallet', 'nama_wallet'=>'OVO'],
        ];

        foreach ($wallets as $wallet) {
            Wallet::create([
                "kategori_wallet" => $wallet['kategori_wallet'],
                "tipe_wallet" => $wallet['tipe_wallet'],
                "nama_wallet" => $wallet['nama_wallet'],
            ]);
        }
    }
}
