<?php

namespace Database\Seeders;

use App\Models\Cap;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $caps = [
            ['nama'=>'3', 'codename'=> 'c.3' ],
            ['nama'=>'300', 'codename'=> 'c.300' ],
            ['nama'=>'375', 'codename'=> 'c.375' ],
            ['nama'=>'8K', 'codename'=> 'c.8K' ],
            ['nama'=>'A', 'codename'=> 'c.A' ],
            ['nama'=>'A33', 'codename'=> 'c.A33' ],
            ['nama'=>'AYU', 'codename'=> 'c.AYU' ],
            ['nama'=>'B', 'codename'=> 'c.B' ],
            ['nama'=>'HT300', 'codename'=> 'c.HT300' ],
            ['nama'=>'J', 'codename'=> 'c.J' ],
            ['nama'=>'KY', 'codename'=> 'c.KY' ],
            ['nama'=>'N', 'codename'=> 'c.N' ],
            ['nama'=>'NX', 'codename'=> 'c.NX' ],
            ['nama'=>'O', 'codename'=> 'c.O' ],
            ['nama'=>'STM', 'codename'=> 'c.STM' ],
            ['nama'=>'gbr.Check', 'codename'=> 'c.gCheck' ],
            ['nama'=>'gbr.Bintang2', 'codename'=> 'c.gBin2' ],
            ['nama'=>'gbr.BintangBulan', 'codename'=> 'c.gBinBul' ],
            ['nama'=>'gbr.Roaster', 'codename'=> 'c.gRoaster' ],
            ['nama'=>'gbr.SBintang', 'codename'=> 'c.gSBin' ],
        ];

        foreach ($caps as $cap) {
            Cap::create([
                'nama' => $cap['nama'],
                'codename' => $cap['codename'],
            ]);
        }
    }
}
