<?php

namespace Database\Seeders;

use App\Models\Mainan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MainanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mainans = [
            ['nama' => 'Bola', 'codename' => 'mai.Bola'],
            ['nama' => 'Dora', 'codename' => 'mai.Dora'],
            ['nama' => 'Hello Kitty', 'codename' => 'mai.HelloKitty'],
            ['nama' => 'Lonceng', 'codename' => 'mai.Lonceng'],
            ['nama' => 'Patrick', 'codename' => 'mai.Patrick'],
            ['nama' => 'SpongeBob', 'codename' => 'mai.SpongeBob'],
        ];

        foreach ($mainans as $mainan) {
            Mainan::create([
                'nama' => $mainan['nama'],
                'codename' => $mainan['codename'],
            ]);
        }
    }
}
