<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            UserSeeder::class,
            ItemTypeSeeder::class,
            TipePerhiasanSeeder::class,
            JenisPerhiasanSeeder::class,
            WarnaEmasSeeder::class,
            KadarSeeder::class,
            CapSeeder::class,
            AgeRangeSeeder::class,
            MerkSeeder::class,
            MataSeeder::class,
            MainanSeeder::class, // 11

            ItemSeeder::class,
            PhotoSeeder::class,
            HargaPasaranSeeder::class,
            WalletSeeder::class,
            AcuanPembukuanSeeder::class,
            // TransactionTest::class,
        ]);
    }
}
