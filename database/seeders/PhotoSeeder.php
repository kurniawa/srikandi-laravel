<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class PhotoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Path ke file JSON
        $path = storage_path('backup/photos.json');

        // Periksa apakah file JSON ada
        if (!File::exists($path)) {
            $this->command->error("File $path tidak ditemukan.");
            return;
        }

        // Baca data dari file JSON
        $json = File::get($path);
        $data = json_decode($json, true);

        // Insert data ke tabel 'photos'
        if (!empty($data)) {
            DB::table('photos')->insert($data);
            $this->command->info('Data berhasil dimasukkan ke tabel photos.');
        } else {
            $this->command->warn('Tidak ada data yang ditemukan di file JSON.');
        }

        // Path ke file JSON
        $path = storage_path('backup/item_photos.json');

        // Periksa apakah file JSON ada
        if (!File::exists($path)) {
            $this->command->error("File $path tidak ditemukan.");
            return;
        }

        // Baca data dari file JSON
        $json = File::get($path);
        $data = json_decode($json, true);

        // Insert data ke tabel 'item_photos'
        if (!empty($data)) {
            DB::table('item_photos')->insert($data);
            $this->command->info('Data berhasil dimasukkan ke tabel item_photos.');
        } else {
            $this->command->warn('Tidak ada data yang ditemukan di file JSON.');
        }
    }
}
