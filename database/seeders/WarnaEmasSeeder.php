<?php

namespace Database\Seeders;

use App\Models\WarnaEmas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class WarnaEmasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $warna_emas = [
        //     ['nama' => 'kuning'],
        //     ['nama' => 'rose gold'],
        //     ['nama' => 'putih'],
        //     ['nama' => 'chrome'],
        // ];
        // foreach ($warna_emas as $we) {
        //     WarnaEmas::create($we);
        // }
        // Path ke file JSON
        $path = storage_path('backup/warna_emas.json');

        // Periksa apakah file JSON ada
        if (!File::exists($path)) {
            $this->command->error("File $path tidak ditemukan.");
            return;
        }

        // Baca data dari file JSON
        $json = File::get($path);
        $data = json_decode($json, true);

        // Insert data ke tabel 'warna_emas'
        if (!empty($data)) {
            DB::table('warna_emas')->insert($data);
            $this->command->info('Data berhasil dimasukkan ke tabel warna_emas.');
        } else {
            $this->command->warn('Tidak ada data yang ditemukan di file JSON.');
        }
    }
}
