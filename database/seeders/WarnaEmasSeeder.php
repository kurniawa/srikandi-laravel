<?php

namespace Database\Seeders;

use App\Models\WarnaEmas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WarnaEmasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $warna_emas = [
            ['nama' => 'kuning'],
            ['nama' => 'rose gold'],
            ['nama' => 'putih'],
            ['nama' => 'chrome'],
        ];
        foreach ($warna_emas as $we) {
            WarnaEmas::create($we);
        }
    }
}
