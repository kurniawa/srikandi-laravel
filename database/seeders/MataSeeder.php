<?php

namespace Database\Seeders;

use App\Models\Mata;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $warnas = [
            ['nama' => 'putih', 'codename' => 'mp'],
            ['nama' => 'merah', 'codename' => 'mm'],
            ['nama' => 'biru', 'codename' => 'mb'],
            ['nama' => 'kuning', 'codename' => 'mk'],
            ['nama' => 'ungu', 'codename' => 'mu'],
            ['nama' => 'hijau', 'codename' => 'mh'],
            ['nama' => 'pink', 'codename' => 'mpink'], 'lila', 'hitam', 'coklat'
        ];

        $level_warnas = ['neutral', 'muda', 'tua'];

        $opacities = ['transparent', 'half-transparent', 'non-transparent'];

        foreach ($warnas as $warna) {
            foreach ($level_warnas as $level_warna) {
                foreach ($opacities as $opacity) {
                    Mata::create([
                        'warna' => $warna,
                        'level_warna' => $level_warna,
                        'opacity' => $opacity,
                    ]);
                }
            }
        }
    }
}
