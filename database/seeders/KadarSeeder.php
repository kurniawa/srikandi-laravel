<?php

namespace Database\Seeders;

use App\Models\Kadar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KadarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kadars = [
            ['kategori' => 'LM Antam Certi (2024)', 'kadar' => 9999],
            ['kategori' => 'LM Antam Certi (2023)', 'kadar' => 9999],
            ['kategori' => 'LM Antam Certi (2021-2022)', 'kadar' => 9999],
            ['kategori' => 'LM Antam Certi (2018-2020)', 'kadar' => 9999],
            ['kategori' => 'LM Antam Retro', 'kadar' => 9999],
            ['kategori' => '24 ct 99,9%', 'kadar' => 9990],
            ['kategori' => '24 ct 99%', 'kadar' => 9900],
            // ['kategori' => '23 ct', 'kadar' => 9900],
            // ['kategori' => '22 ct', 'kadar' => 9900],
            // ['kategori' => '21 ct', 'kadar' => 9900],
            // ['kategori' => '20 ct', 'kadar' => 9900],
            // ['kategori' => '19 ct', 'kadar' => 9900],
            // ['kategori' => '18 ct', 'kadar' => 9900],
            // ['kategori' => '17 ct', 'kadar' => 9900],
            // ['kategori' => '16 ct', 'kadar' => 9900],
            // ['kategori' => '15 ct', 'kadar' => 9900],
            // ['kategori' => '14 ct', 'kadar' => 9900],
            // ['kategori' => '13 ct', 'kadar' => 9900],
            // ['kategori' => '12 ct', 'kadar' => 5000],
            // ['kategori' => '11 ct', 'kadar' => 4583],
            // ['kategori' => '10 ct', 'kadar' => 4166],
            // ['kategori' => '9 ct', 'kadar' => 3750],
            // ['kategori' => '8 ct', 'kadar' => 3333],
            // ['kategori' => '7 ct', 'kadar' => 2916],
            ['kategori' => '9500', 'kadar' => 9500, 'poin_susut' => 7, 'poin_tambah' => 10],
            ['kategori' => '9000', 'kadar' => 9000, 'poin_susut' => 8, 'poin_tambah' => 10],
            ['kategori' => '7500', 'kadar' => 7500, 'poin_susut' => 10, 'poin_tambah' => 10],
            ['kategori' => '7000', 'kadar' => 7000, 'poin_susut' => 10, 'poin_tambah' => 10],
            ['kategori' => '4200', 'kadar' => 4200, 'poin_susut' => 10, 'poin_tambah' => 10],
            ['kategori' => '3750', 'kadar' => 3750, 'poin_susut' => 10, 'poin_tambah' => 10],
        ];

        foreach ($kadars as $kadar) {
            Kadar::create([
                'kategori' => $kadar['kategori'],
                'kadar' => $kadar['kadar'],
            ]);
        }
    }
}
