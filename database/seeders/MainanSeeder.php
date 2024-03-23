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
            [ 'nama'=>'Bola', 'codename'=> 'maiBola' ],
            [ 'nama'=>'Dora', 'codename'=> 'maiDora' ],
            [ 'nama'=>'Hello Kitty', 'codename'=> 'maiHelloKitty' ],
            [ 'nama'=>'Lonceng', 'codename'=> 'maiLonceng' ],
            [ 'nama'=>'Patrick', 'codename'=> 'maiPatrick' ],
            [ 'nama'=>'SpongeBob', 'codename'=> 'maiSpongeBob' ],
        ];

        foreach ($mainans as $mainan) {
            Mainan::create([
                'nama' => $mainan['nama'],
                'codename' => $mainan['codename'],
            ]);
        }
    }
}
