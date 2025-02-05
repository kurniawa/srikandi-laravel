<?php

namespace Database\Seeders;

use App\Models\Mata;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class MataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $warnas = [
        //     ['nama' => 'putih', 'codename' => 'm.p'],
        //     ['nama' => 'merah', 'codename' => 'm.m'],
        //     ['nama' => 'biru', 'codename' => 'm.b'],
        //     ['nama' => 'kuning', 'codename' => 'm.k'],
        //     ['nama' => 'ungu', 'codename' => 'm.u'],
        //     ['nama' => 'hijau', 'codename' => 'm.hijau'],
        //     ['nama' => 'pink', 'codename' => 'm.pink'],
        //     ['nama' => 'lila', 'codename' => 'm.lila'],
        //     ['nama' => 'hitam', 'codename' => 'm.hitam'],
        //     ['nama' => 'coklat', 'codename' => 'm.c'],
        //     ['nama' => 'orange', 'codename' => 'm.or'],
        // ];

        // $level_warnas = [
        //     ['nama' => 'neutral', 'codename' => 'lw.n'],
        //     ['nama' => 'muda', 'codename' => 'lw.m'],
        //     ['nama' => 'tua', 'codename' => 'lw.t']
        // ];

        // $opacities = [
        //     ['nama' => 'transparent', 'codename' => 'opac.t'],
        //     ['nama' => 'half-transparent', 'codename' => 'opac.ht'],
        //     ['nama' => 'non-transparent', 'codename' => 'opac.nt']
        // ];

        // $barcode = 1;
        // foreach ($warnas as $warna) {
        //     foreach ($level_warnas as $level_warna) {
        //         foreach ($opacities as $opacity) {
        //             // $codename = "$warna[codename]-$level_warna[codename]-$opacity[codename]";
        //             $codename = "$warna[codename]";
        //             Mata::create([
        //                 'warna' => $warna['nama'],
        //                 'level_warna' => $level_warna['nama'],
        //                 'opacity' => $opacity['nama'],
        //                 'codename' => $codename,
        //                 'barcode' => (string)$barcode,
        //             ]);
        //             $barcode++;
        //         }
        //     }
        // }

        // Path ke file JSON
        $path = storage_path('backup/matas.json');

        // Periksa apakah file JSON ada
        if (!File::exists($path)) {
            $this->command->error("File $path tidak ditemukan.");
            return;
        }

        // Baca data dari file JSON
        $json = File::get($path);
        $data = json_decode($json, true);

        // Insert data ke tabel 'matas'
        if (!empty($data)) {
            DB::table('matas')->insert($data);
            $this->command->info('Data berhasil dimasukkan ke tabel matas.');
        } else {
            $this->command->warn('Tidak ada data yang ditemukan di file JSON.');
        }
    }
}
