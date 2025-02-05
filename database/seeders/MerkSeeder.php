<?php

namespace Database\Seeders;

use App\Models\Merk;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class MerkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $merks = [
        //     ['nama' => 'Antam', 'codename'=>'m.Antam'],
        //     ['nama' => 'UBS', 'codename'=>'m.UBS'],
        // ];

        // foreach ($merks as $merk) {
        //     Merk::create([
        //         'nama' => $merk['nama'],
        //         'codename' => $merk['codename']
        //     ]);
        // }

        // Path ke file JSON
        $path = storage_path('backup/merks.json');

        // Periksa apakah file JSON ada
        if (!File::exists($path)) {
            $this->command->error("File $path tidak ditemukan.");
            return;
        }

        // Baca data dari file JSON
        $json = File::get($path);
        $data = json_decode($json, true);

        // Insert data ke tabel 'merks'
        if (!empty($data)) {
            DB::table('merks')->insert($data);
            $this->command->info('Data berhasil dimasukkan ke tabel merks.');
        } else {
            $this->command->warn('Tidak ada data yang ditemukan di file JSON.');
        }
    }
}
