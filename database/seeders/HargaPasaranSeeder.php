<?php

namespace Database\Seeders;

use App\Models\HargaPasaran;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HargaPasaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $harga_pasarans = [
            ['kategori' => 'CT', 'kadar' => 9900, 'harga_beli' => 133500000, 'harga_buyback' => 129000000],
            ['kategori' => 'LM', 'kadar' => 9900, 'harga_beli' => 133500000, 'harga_buyback' => 129000000],
        ];

        foreach ($harga_pasarans as $harga_pasaran) {
            HargaPasaran::create([
                'kategori' => $harga_pasaran['kategori'],
                'kadar' => $harga_pasaran['kadar'],
                'harga_beli' => $harga_pasaran['harga_beli'],
                'harga_buyback' => $harga_pasaran['harga_buyback'],
            ]);
        }
    }
}
