<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class MainanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Path ke file JSON
        $path = storage_path('backup/mainans.json');

        // Periksa apakah file JSON ada
        if (!File::exists($path)) {
            $this->command->error("File $path tidak ditemukan.");
            return;
        }

        // Baca data dari file JSON
        $json = File::get($path);
        $data = json_decode($json, true);

        // Insert data ke tabel 'mainans'
        if (!empty($data)) {
            DB::table('mainans')->insert($data);
            $this->command->info('Data berhasil dimasukkan ke tabel mainans.');
        } else {
            $this->command->warn('Tidak ada data yang ditemukan di file JSON.');
        }
    }
}
