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
            ['kategori' => '24 ct 99%', 'kadar' => "99", 'harga_beli' => "1232500", 'harga_buyback' => "1190000", 'created_at' => '2024-07-15 00:00:00'], // spread harga sekitar 3,4%
            ['kategori' => 'LM Antam Certi (2024)', 'kadar' => "99.99", 'harga_beli' => "1335000", 'harga_buyback' => "1290000", 'created_at' => '2024-07-15 00:00:00'],
        ];

        foreach ($harga_pasarans as $harga_pasaran) {
            HargaPasaran::create([
                'kategori' => $harga_pasaran['kategori'],
                'kadar' => $harga_pasaran['kadar'],
                'harga_beli' => $harga_pasaran['harga_beli'],
                'harga_buyback' => $harga_pasaran['harga_buyback'],
                'created_at' => $harga_pasaran['created_at'],
            ]);
        }
    }
}
