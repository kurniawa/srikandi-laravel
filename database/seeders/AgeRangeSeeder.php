<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class AgeRangeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $age_ranges = [
        //     [
        //         'range' => 'dewasa',
        //         'barcode' => 1,
        //     ],
        //     [
        //         'range' => 'anak',
        //         'barcode' => 2,
        //     ],
        //     [
        //         'range' => 'bayi',
        //         'barcode' => 3,
        //     ]
        // ];
        // DB::table('age_ranges')->insert($age_ranges);

        // Path ke file JSON
        $path = storage_path('backup/age_ranges.json');

        // Periksa apakah file JSON ada
        if (!File::exists($path)) {
            $this->command->error("File $path tidak ditemukan.");
            return;
        }

        // Baca data dari file JSON
        $json = File::get($path);
        $data = json_decode($json, true);

        // Insert data ke tabel 'age_ranges'
        if (!empty($data)) {
            DB::table('age_ranges')->insert($data);
            $this->command->info('Data berhasil dimasukkan ke tabel age_ranges.');
        } else {
            $this->command->warn('Tidak ada data yang ditemukan di file JSON.');
        }
    }
}
