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
            ['kategori' => 'LM', 'kadar' => 9999],
            ['kategori' => 'CT', 'kadar' => 9900],
            ['kategori' => '3750', 'kadar' => 3750],
            ['kategori' => '4200', 'kadar' => 4200],
            ['kategori' => '7000', 'kadar' => 7000],
            ['kategori' => '7500', 'kadar' => 7500],
        ];

        foreach ($kadars as $kadar) {
            Kadar::create([
                'kategori' => $kadar['kategori'],
                'kadar' => $kadar['kadar'],
            ]);
        }
    }
}
