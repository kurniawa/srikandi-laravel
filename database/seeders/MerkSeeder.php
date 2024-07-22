<?php

namespace Database\Seeders;

use App\Models\Merk;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MerkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $merks = [
            ['nama' => 'Antam', 'codename'=>'m.Antam'],
            ['nama' => 'UBS', 'codename'=>'m.UBS'],
        ];

        foreach ($merks as $merk) {
            Merk::create([
                'nama' => $merk['nama'],
                'codename' => $merk['codename']
            ]);
        }
    }
}
