<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\JenisPerhiasan;
use App\Models\TipePerhiasan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Path ke file JSON
        $path = storage_path('backup/items.json');

        // Periksa apakah file JSON ada
        if (!File::exists($path)) {
            $this->command->error("File $path tidak ditemukan.");
            return;
        }

        // Baca data dari file JSON
        $json = File::get($path);
        $data = json_decode($json, true);

        // Insert data ke tabel 'items'
        if (!empty($data)) {
            DB::table('items')->insert($data);
            $this->command->info('Data berhasil dimasukkan ke tabel items.');
        } else {
            $this->command->warn('Tidak ada data yang ditemukan di file JSON.');
        }

        // item_matas
        // Path ke file JSON
        $path = storage_path('backup/item_matas.json');

        // Periksa apakah file JSON ada
        if (!File::exists($path)) {
            $this->command->error("File $path tidak ditemukan.");
            return;
        }

        // Baca data dari file JSON
        $json = File::get($path);
        $data = json_decode($json, true);

        // Insert data ke tabel 'item_matas'
        if (!empty($data)) {
            DB::table('item_matas')->insert($data);
            $this->command->info('Data berhasil dimasukkan ke tabel item_matas.');
        } else {
            $this->command->warn('Tidak ada data yang ditemukan di file JSON.');
        }
        // END - item_matas

        // item_mainans
        // Path ke file JSON
        $path = storage_path('backup/item_mainans.json');

        // Periksa apakah file JSON ada
        if (!File::exists($path)) {
            $this->command->error("File $path tidak ditemukan.");
            return;
        }

        // Baca data dari file JSON
        $json = File::get($path);
        $data = json_decode($json, true);

        // Insert data ke tabel 'item_mainans'
        if (!empty($data)) {
            DB::table('item_mainans')->insert($data);
            $this->command->info('Data berhasil dimasukkan ke tabel item_mainans.');
        } else {
            $this->command->warn('Tidak ada data yang ditemukan di file JSON.');
        }
        // END - item_mainans
    }
}
