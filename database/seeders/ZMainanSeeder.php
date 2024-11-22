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
            ['nama' => 'Bola', 'codename' => 'm-Bola'],
            ['nama' => 'Dora', 'codename' => 'm-Dora'],
            ['nama' => 'Hello Kitty', 'codename' => 'm-HelloKitty'],
            ['nama' => 'Lonceng', 'codename' => 'm-Lonceng'],
            ['nama' => 'Patrick', 'codename' => 'm-Patrick'],
            ['nama' => 'SpongeBob', 'codename' => 'm-SpongeBob'],
        ];

        foreach ($mainans as $mainan) {
            Mainan::create([
                'nama' => $mainan['nama'],
                'codename' => $mainan['codename'],
            ]);
        }
    }
}
