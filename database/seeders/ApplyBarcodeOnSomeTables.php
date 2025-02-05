<?php

namespace Database\Seeders;

use App\Models\AgeRange;
use App\Models\Cap;
use App\Models\JenisPerhiasan;
use App\Models\Kadar;
use App\Models\Merk;
use App\Models\TipePerhiasan;
use App\Models\WarnaEmas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApplyBarcodeOnSomeTables extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seeding barcode pada data tipe_perhiasans
        TipePerhiasan::query()->update(['barcode' => null]);
        $tipe_perhiasans = TipePerhiasan::all();
        $barcode = 1;
        foreach ($tipe_perhiasans as $tipe_perhiasan) {
            // Menghindari angka 4 pada barcode
            $barcode = str_contains((string)$barcode, '4') ? (++$barcode) : $barcode;
            $tipe_perhiasan->barcode = (string)$barcode;
            $tipe_perhiasan->save();
            $barcode++;
        }

        // Seeding barcode pada data jenis_perhiasan berdasarkan tipe_perhiasan nya
        JenisPerhiasan::query()->update(['barcode' => null]);
        $tipe_perhiasans = TipePerhiasan::select('nama')->get();
        foreach ($tipe_perhiasans as $tipe_perhiasan) {
            $jenis_perhiasans = JenisPerhiasan::where('tipe_perhiasan', $tipe_perhiasan->nama)->orderBy('nama')->get();
            $barcode = 1;
            foreach ($jenis_perhiasans as $jenis_perhiasan) {
                // Menghindari angka 4 pada barcode
                while (str_contains((string)$barcode, '4')) {$barcode++;}
                $jenis_perhiasan->barcode = (string)$barcode;
                $jenis_perhiasan->save();
                $barcode++;
            }
        }

        // Seeding barcode pada warna_emas
        WarnaEmas::query()->update(['barcode' => null]);
        $warna_emass = WarnaEmas::all();
        $barcode = 1;
        foreach ($warna_emass as $warna_emas) {
            // Menghindari angka 4 pada barcode
            $barcode = str_contains((string)$barcode, '4') ? (++$barcode) : $barcode;
            $warna_emas->barcode = (string)$barcode;
            $warna_emas->save();
            $barcode++;
        }

        // Seeding barcode pada kadar
        Kadar::query()->update(['barcode' => null]);
        $kadars = Kadar::all();
        foreach ($kadars as $kadar) {
            $barcode = $kadar->kadar * 100;
            $kadar->barcode = (string)$barcode;
            $kadar->save();
        }

        // Seeding barcode pada cap
        Cap::query()->update(['barcode' => null]);
        $caps = Cap::all();
        $barcode = 1;
        foreach ($caps as $cap) {
            // Menghindari angka 4 pada barcode
            while (str_contains((string)$barcode, '4')) {$barcode++;}
            $cap->barcode = (string)$barcode;
            $cap->save();
            $barcode++;
        }

        // Seeding barcode for age_ranges
        AgeRange::query()->update(['barcode' => null]);
        $age_ranges = AgeRange::all();
        $barcode = 1;
        foreach ($age_ranges as $age_range) {
            // Menghindari angka 4 pada barcode
            $barcode = str_contains((string)$barcode, '4') ? (++$barcode) : $barcode;
            $age_range->barcode = (string)$barcode;
            $age_range->save();
            $barcode++;
        }

        // Seeding barcode for merks
        Merk::query()->update(['barcode' => null]);
        $merks = Merk::all();
        $barcode = 1;
        foreach ($merks as $merk) {
            // Menghindari angka 4 pada barcode
            $barcode = str_contains((string)$barcode, '4') ? (++$barcode) : $barcode;
            $merk->barcode = (string)$barcode;
            $merk->save();
            $barcode++;
        }

    }
}
