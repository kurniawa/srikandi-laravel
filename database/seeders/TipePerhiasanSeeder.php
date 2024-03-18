<?php

namespace Database\Seeders;

use App\Models\JenisPerhiasan;
use App\Models\TipePerhiasan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipePerhiasanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipe_perhiasans = [
            ['nama' => 'Anting', 'codename' => 'AT'],
            ['nama' => 'Giwang', 'codename' => 'GW'],
            ['nama' => 'Cincin', 'codename' => 'CC'],
            ['nama' => 'Gelang Rantai', 'codename' => 'GLR'],
            ['nama' => 'Gelang Bulat', 'codename' => 'GLB'],
            ['nama' => 'Kalung', 'codename' => 'KL'],
            ['nama' => 'Liontin', 'codename' => 'Lio'],
        ];

        $jenis_perhiasans = [
            // ANTING
            ['nama' => 'Desy', 'tipe_perhiasan' => 'Anting', 'tipe_perhiasan_id' => '1', 'codename' => ''],
            ['nama' => 'Desy Polos', 'tipe_perhiasan' => 'Anting', 'tipe_perhiasan_id' => '1', 'codename' => ''],
            ['nama' => 'Gipsy', 'tipe_perhiasan' => 'Anting', 'tipe_perhiasan_id' => '1', 'codename' => ''],
            ['nama' => 'Jepit', 'tipe_perhiasan' => 'Anting', 'tipe_perhiasan_id' => '1', 'codename' => ''],
            ['nama' => 'Kait', 'tipe_perhiasan' => 'Anting', 'tipe_perhiasan_id' => '1', 'codename' => ''],
            ['nama' => 'Kait Panjang', 'tipe_perhiasan' => 'Anting', 'tipe_perhiasan_id' => '1', 'codename' => ''],
            ['nama' => 'Kenip', 'tipe_perhiasan' => 'Anting', 'tipe_perhiasan_id' => '1', 'codename' => ''],
            ['nama' => 'Tusuk Sate', 'tipe_perhiasan' => 'Anting', 'tipe_perhiasan_id' => '1', 'codename' => ''],
            // GIWANG
            ['nama' => 'Mata Burung', 'tipe_perhiasan' => 'Giwang', 'tipe_perhiasan_id' => '2', 'codename' => ''],
            ['nama' => 'Mata Desy', 'tipe_perhiasan' => 'Giwang', 'tipe_perhiasan_id' => '2', 'codename' => ''],
            ['nama' => 'Pentol', 'tipe_perhiasan' => 'Giwang', 'tipe_perhiasan_id' => '2', 'codename' => ''],
            ['nama' => 'Pentol Polos', 'tipe_perhiasan' => 'Giwang', 'tipe_perhiasan_id' => '2', 'codename' => ''],
            ['nama' => 'Kembang', 'tipe_perhiasan' => 'Giwang', 'tipe_perhiasan_id' => '2', 'codename' => ''],
            ['nama' => 'Kembang Polos', 'tipe_perhiasan' => 'Giwang', 'tipe_perhiasan_id' => '2', 'codename' => ''],
            ['nama' => 'Hello Kitty', 'tipe_perhiasan' => 'Giwang', 'tipe_perhiasan_id' => '2', 'codename' => ''],
            ['nama' => 'Tribal', 'tipe_perhiasan' => 'Giwang', 'tipe_perhiasan_id' => '2', 'codename' => ''],
            ['nama' => 'Tribal Pasir', 'tipe_perhiasan' => 'Giwang', 'tipe_perhiasan_id' => '2', 'codename' => ''],
            ['nama' => 'Tribal Ukir', 'tipe_perhiasan' => 'Giwang', 'tipe_perhiasan_id' => '2', 'codename' => ''],
            ['nama' => '1/2 Tribal', 'tipe_perhiasan' => 'Giwang', 'tipe_perhiasan_id' => '2', 'codename' => ''],
            ['nama' => 'Bintang', 'tipe_perhiasan' => 'Giwang', 'tipe_perhiasan_id' => '2', 'codename' => ''],
            ['nama' => 'Chanel', 'tipe_perhiasan' => 'Giwang', 'tipe_perhiasan_id' => '2', 'codename' => ''],
            ['nama' => 'Segitiga', 'tipe_perhiasan' => 'Giwang', 'tipe_perhiasan_id' => '2', 'codename' => ''],
            ['nama' => 'Kotak', 'tipe_perhiasan' => 'Giwang', 'tipe_perhiasan_id' => '2', 'codename' => ''],
            ['nama' => 'Fashion', 'tipe_perhiasan' => 'Giwang', 'tipe_perhiasan_id' => '2', 'codename' => ''],
            ['nama' => 'Panjang', 'tipe_perhiasan' => 'Giwang', 'tipe_perhiasan_id' => '2', 'codename' => ''],
            // CINCIN
            ['nama' => '1/2 Rantai', 'tipe_perhiasan' => 'Cincin', 'tipe_perhiasan_id' => '3', 'codename' => ''],
            ['nama' => '1/2 Pasir', 'tipe_perhiasan' => 'Cincin', 'tipe_perhiasan_id' => '3', 'codename' => ''],
            ['nama' => 'Bambu Ukir', 'tipe_perhiasan' => 'Cincin', 'tipe_perhiasan_id' => '3', 'codename' => ''],
            ['nama' => 'Dubai', 'tipe_perhiasan' => 'Cincin', 'tipe_perhiasan_id' => '3', 'codename' => ''],
            ['nama' => 'Listring Aurel', 'tipe_perhiasan' => 'Cincin', 'tipe_perhiasan_id' => '3', 'codename' => ''],
            ['nama' => 'Listring V', 'tipe_perhiasan' => 'Cincin', 'tipe_perhiasan_id' => '3', 'codename' => ''],
            ['nama' => 'Patkok', 'tipe_perhiasan' => 'Cincin', 'tipe_perhiasan_id' => '3', 'codename' => ''],
            ['nama' => 'Ring Polos', 'tipe_perhiasan' => 'Cincin', 'tipe_perhiasan_id' => '3', 'codename' => ''],
            ['nama' => 'Stempel', 'tipe_perhiasan' => 'Cincin', 'tipe_perhiasan_id' => '3', 'codename' => ''],
            ['nama' => 'Wedding', 'tipe_perhiasan' => 'Cincin', 'tipe_perhiasan_id' => '3', 'codename' => ''],
            // GELANG RANTAI
            ['nama' => 'Wedding', 'tipe_perhiasan' => 'Gelang Rantai', 'tipe_perhiasan_id' => '3', 'codename' => ''],
            ['nama' => 'Biji Lada Kombinasi', 'tipe_perhiasan' => 'Gelang Rantai', 'tipe_perhiasan_id' => '4', 'codename' => ''],
            ['nama' => 'Cor', 'tipe_perhiasan' => 'Gelang Rantai', 'tipe_perhiasan_id' => '4', 'codename' => ''],
            ['nama' => 'Serut', 'tipe_perhiasan' => 'Gelang Rantai', 'tipe_perhiasan_id' => '4', 'codename' => ''],
            ['nama' => 'Holo', 'tipe_perhiasan' => 'Gelang Rantai', 'tipe_perhiasan_id' => '4', 'codename' => ''],
            ['nama' => 'Holo Kombinasi', 'tipe_perhiasan' => 'Gelang Rantai', 'tipe_perhiasan_id' => '4', 'codename' => ''],
            ['nama' => 'Holo Safir', 'tipe_perhiasan' => 'Gelang Rantai', 'tipe_perhiasan_id' => '4', 'codename' => ''],
            ['nama' => 'Holo Ukir', 'tipe_perhiasan' => 'Gelang Rantai', 'tipe_perhiasan_id' => '4', 'codename' => ''],
            ['nama' => 'Rantai Gepeng', 'tipe_perhiasan' => 'Gelang Rantai', 'tipe_perhiasan_id' => '4', 'codename' => ''],
            ['nama' => 'Sisik Naga', 'tipe_perhiasan' => 'Gelang Rantai', 'tipe_perhiasan_id' => '4', 'codename' => ''],
            ['nama' => 'Sisik Naga Double', 'tipe_perhiasan' => 'Gelang Rantai', 'tipe_perhiasan_id' => '4', 'codename' => ''],
            ['nama' => 'Susun Sirih', 'tipe_perhiasan' => 'Gelang Rantai', 'tipe_perhiasan_id' => '4', 'codename' => ''],
            // GELANG BULAT
            ['nama' => 'Cartier', 'tipe_perhiasan' => 'Gelang Bulat', 'tipe_perhiasan_id' => '5', 'codename' => ''],
            ['nama' => 'Gelombang', 'tipe_perhiasan' => 'Gelang Bulat', 'tipe_perhiasan_id' => '5', 'codename' => ''],
            ['nama' => 'Keroncong', 'tipe_perhiasan' => 'Gelang Bulat', 'tipe_perhiasan_id' => '5', 'codename' => ''],
            ['nama' => 'Fashion', 'tipe_perhiasan' => 'Gelang Bulat', 'tipe_perhiasan_id' => '5', 'codename' => ''],
            ['nama' => 'Ular', 'tipe_perhiasan' => 'Gelang Bulat', 'tipe_perhiasan_id' => '5', 'codename' => ''],
            // KALUNG
            ['nama' => 'Aurel', 'tipe_perhiasan' => 'Kalung', 'tipe_perhiasan_id' => '6', 'codename' => ''],
            ['nama' => 'Balok Mini', 'tipe_perhiasan' => 'Kalung', 'tipe_perhiasan_id' => '6', 'codename' => ''],
            ['nama' => 'Biji Lada', 'tipe_perhiasan' => 'Kalung', 'tipe_perhiasan_id' => '6', 'codename' => ''],
            ['nama' => 'Biji Cabe', 'tipe_perhiasan' => 'Kalung', 'tipe_perhiasan_id' => '6', 'codename' => ''],
            ['nama' => 'Biji Padi', 'tipe_perhiasan' => 'Kalung', 'tipe_perhiasan_id' => '6', 'codename' => ''],
            ['nama' => 'Biji Timun', 'tipe_perhiasan' => 'Kalung', 'tipe_perhiasan_id' => '6', 'codename' => ''],
            ['nama' => 'Biji Timun Lilit', 'tipe_perhiasan' => 'Kalung', 'tipe_perhiasan_id' => '6', 'codename' => ''],
            ['nama' => 'Boston', 'tipe_perhiasan' => 'Kalung', 'tipe_perhiasan_id' => '6', 'codename' => ''],
            ['nama' => 'Cassandra', 'tipe_perhiasan' => 'Kalung', 'tipe_perhiasan_id' => '6', 'codename' => ''],
            ['nama' => 'Cassandra Ukir', 'tipe_perhiasan' => 'Kalung', 'tipe_perhiasan_id' => '6', 'codename' => ''],
            ['nama' => 'Gepeng', 'tipe_perhiasan' => 'Kalung', 'tipe_perhiasan_id' => '6', 'codename' => ''],
            ['nama' => 'Holo', 'tipe_perhiasan' => 'Kalung', 'tipe_perhiasan_id' => '6', 'codename' => ''],
            ['nama' => 'Holo Safir', 'tipe_perhiasan' => 'Kalung', 'tipe_perhiasan_id' => '6', 'codename' => ''],
            ['nama' => 'Holo Ukir', 'tipe_perhiasan' => 'Kalung', 'tipe_perhiasan_id' => '6', 'codename' => ''],
            ['nama' => 'Italy', 'tipe_perhiasan' => 'Kalung', 'tipe_perhiasan_id' => '6', 'codename' => ''],
            ['nama' => 'Italy Kaca', 'tipe_perhiasan' => 'Kalung', 'tipe_perhiasan_id' => '6', 'codename' => ''],
            ['nama' => 'Italy Santa', 'tipe_perhiasan' => 'Kalung', 'tipe_perhiasan_id' => '6', 'codename' => ''],
            ['nama' => 'Milano Bulat', 'tipe_perhiasan' => 'Kalung', 'tipe_perhiasan_id' => '6', 'codename' => ''],
            ['nama' => 'Milano Kotak', 'tipe_perhiasan' => 'Kalung', 'tipe_perhiasan_id' => '6', 'codename' => ''],
            ['nama' => 'Milano Gepeng', 'tipe_perhiasan' => 'Kalung', 'tipe_perhiasan_id' => '6', 'codename' => ''],
            ['nama' => 'Miyata', 'tipe_perhiasan' => 'Kalung', 'tipe_perhiasan_id' => '6', 'codename' => ''],
            ['nama' => 'Nori', 'tipe_perhiasan' => 'Kalung', 'tipe_perhiasan_id' => '6', 'codename' => ''],
            ['nama' => 'Nori Balok', 'tipe_perhiasan' => 'Kalung', 'tipe_perhiasan_id' => '6', 'codename' => ''],
            ['nama' => 'Nori Balok Ukir', 'tipe_perhiasan' => 'Kalung', 'tipe_perhiasan_id' => '6', 'codename' => ''],
            ['nama' => 'Plexi', 'tipe_perhiasan' => 'Kalung', 'tipe_perhiasan_id' => '6', 'codename' => ''],
            ['nama' => 'Rantai Gepeng', 'tipe_perhiasan' => 'Kalung', 'tipe_perhiasan_id' => '6', 'codename' => ''],
            ['nama' => 'Santa', 'tipe_perhiasan' => 'Kalung', 'tipe_perhiasan_id' => '6', 'codename' => ''],
            ['nama' => 'Sela-Seli/Lovina', 'tipe_perhiasan' => 'Kalung', 'tipe_perhiasan_id' => '6', 'codename' => ''],
            ['nama' => 'Silinder', 'tipe_perhiasan' => 'Kalung', 'tipe_perhiasan_id' => '6', 'codename' => ''],
            ['nama' => 'Tambang Lilit', 'tipe_perhiasan' => 'Kalung', 'tipe_perhiasan_id' => '6', 'codename' => ''],
            ['nama' => 'Tambang Variasi', 'tipe_perhiasan' => 'Kalung', 'tipe_perhiasan_id' => '6', 'codename' => ''],
            // LIONTIN
            ['nama' => 'Chanel', 'tipe_perhiasan' => 'Liontin', 'tipe_perhiasan_id' => '7', 'codename' => ''],
            ['nama' => 'Desy', 'tipe_perhiasan' => 'Liontin', 'tipe_perhiasan_id' => '7', 'codename' => ''],
            ['nama' => 'Louis Vuitton', 'tipe_perhiasan' => 'Liontin', 'tipe_perhiasan_id' => '7', 'codename' => ''],
            ['nama' => 'Gucci', 'tipe_perhiasan' => 'Liontin', 'tipe_perhiasan_id' => '7', 'codename' => ''],
            ['nama' => 'Salib', 'tipe_perhiasan' => 'Liontin', 'tipe_perhiasan_id' => '7', 'codename' => ''],
            ['nama' => 'Batu', 'tipe_perhiasan' => 'Liontin', 'tipe_perhiasan_id' => '7', 'codename' => ''],
            ['nama' => 'Huruf', 'tipe_perhiasan' => 'Liontin', 'tipe_perhiasan_id' => '7', 'codename' => ''],
            ['nama' => 'Dubai Ukir Pohon Kelapa', 'tipe_perhiasan' => 'Liontin', 'tipe_perhiasan_id' => '7', 'codename' => ''],

        ];

        foreach ($tipe_perhiasans as $tipe_perhiasan) {
            TipePerhiasan::create([
                'nama' => $tipe_perhiasan['nama'],
                'codename' => $tipe_perhiasan['codename'],
            ]);
        }

        foreach ($jenis_perhiasans as $jenis_perhiasan) {
            $codename = $jenis_perhiasan['codename'];
            if ($codename === '') {
                $codename = null;
            }
            JenisPerhiasan::create([
                'nama' => $jenis_perhiasan['nama'],
                'tipe_perhiasan' => $jenis_perhiasan['tipe_perhiasan'],
                'tipe_perhiasan_id' => $jenis_perhiasan['tipe_perhiasan_id'],
                'codename' => $codename,
            ]);
        }
    }
}
