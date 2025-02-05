<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $item_types = [
            [
                'type' => 'perhiasan',
                'barcode' => '1',
            ], [
                'type' => 'LM',
                'barcode' => '2',
            ], [
                'type' => 'kotak perhiasan',
                'barcode' => '3',
            ],
        ];

        DB::table('item_types')->insert($item_types);
    }
}
