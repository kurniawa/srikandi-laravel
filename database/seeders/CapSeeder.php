<?php

namespace Database\Seeders;

use App\Models\Cap;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class CapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $caps = [
        //     ['nama'=>'3', 'codename'=> 'c.3' ],
        //     ['nama'=>'300', 'codename'=> 'c.300' ],
        //     ['nama'=>'375', 'codename'=> 'c.375' ],
        //     ['nama'=>'8K', 'codename'=> 'c.8K' ],
        //     ['nama'=>'A', 'codename'=> 'c.A' ],
        //     ['nama'=>'A33', 'codename'=> 'c.A33' ],
        //     ['nama'=>'AYU', 'codename'=> 'c.AYU' ],
        //     ['nama'=>'B', 'codename'=> 'c.B' ],
        //     ['nama'=>'HT300', 'codename'=> 'c.HT300' ],
        //     ['nama'=>'J', 'codename'=> 'c.J' ],
        //     ['nama'=>'KY', 'codename'=> 'c.KY' ],
        //     ['nama'=>'N', 'codename'=> 'c.N' ],
        //     ['nama'=>'NX', 'codename'=> 'c.NX' ],
        //     ['nama'=>'O', 'codename'=> 'c.O' ],
        //     ['nama'=>'STM', 'codename'=> 'c.STM' ],
        //     ['nama'=>'gambar Check', 'codename'=> 'c.gbr.Check' ],
        //     ['nama'=>'gambar Bintang2', 'codename'=> 'c.gbr.Bin2' ],
        //     ['nama'=>'gambar BintangBulan', 'codename'=> 'c.gbr.BinBul' ],
        //     ['nama'=>'gambar Roaster', 'codename'=> 'c.gbr.Roaster' ],
        //     ['nama'=>'gambar SBintang', 'codename'=> 'c.gbr.SBin' ],
        // ];

        // foreach ($caps as $cap) {
        //     Cap::create([
        //         'nama' => $cap['nama'],
        //         'codename' => $cap['codename'],
        //     ]);
        // }

        // Path ke file JSON
        $path = storage_path('backup/caps.json');

        // Periksa apakah file JSON ada
        if (!File::exists($path)) {
            $this->command->error("File $path tidak ditemukan.");
            return;
        }

        // Baca data dari file JSON
        $json = File::get($path);
        $data = json_decode($json, true);

        // Insert data ke tabel 'caps'
        if (!empty($data)) {
            DB::table('caps')->insert($data);
            $this->command->info('Data berhasil dimasukkan ke tabel caps.');
        } else {
            $this->command->warn('Tidak ada data yang ditemukan di file JSON.');
        }
    }
}
