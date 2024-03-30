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
        $warnas = ['putih', 'merah', 'biru', 'kuning', 'ungu', 'hijau', 'pink', 'lila', 'hitam', 'coklat'];

        $level_warnas = ['netral', 'muda', 'tua'];

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
