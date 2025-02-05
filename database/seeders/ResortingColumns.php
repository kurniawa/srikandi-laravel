<?php

namespace Database\Seeders;

use App\Models\Cap;
use App\Models\JenisPerhiasan;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ResortingColumns extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // try {
        //     // Ambil data yang sudah terurut
        //     $sortedData = JenisPerhiasan::orderBy('tipe_perhiasan')
        //         ->orderBy('nama')
        //         ->get()
        //         ->map(function ($item) {
        //             // // Konversi ke array terlebih dahulu
        //             $item = $item->toArray();

        //             // Hapus kolom 'id' sebelum insert
        //             unset($item['id']);

        //             $item['created_at'] = Carbon::parse($item['created_at'])->format('Y-m-d H:i:s');
        //             $item['updated_at'] = Carbon::parse($item['updated_at'])->format('Y-m-d H:i:s');
        //             return $item;
        //         })
        //         ->toArray();

        //     JenisPerhiasan::truncate();
        //     JenisPerhiasan::insert($sortedData);
        // } catch (\Throwable $th) {
        //     Log::error('Error during transaction: ' . $th->getMessage());
        //     throw $th; // Bubble up the error
        // }
        
        try {
            // Ambil data yang sudah terurut
            $sortedData = Cap::orderBy('type')
                ->orderBy('name')
                ->get()
                ->map(function ($item) {
                    // Konversi ke array terlebih dahulu
                    $item = $item->toArray();

                    // Hapus kolom 'id' sebelum insert
                    unset($item['id']);

                    $item['created_at'] = Carbon::parse($item['created_at'])->format('Y-m-d H:i:s');
                    $item['updated_at'] = Carbon::parse($item['updated_at'])->format('Y-m-d H:i:s');
                    return $item;
                })
                ->toArray();
        
            // Hapus data lama
            Cap::truncate();
        
            // Masukkan data baru
            Cap::insert($sortedData);
        
            // // Update barcode
            // $barcode = 1;
            // Cap::orderBy('type')->orderBy('name')->each(function ($cap) use (&$barcode) {
            //     $cap->update(['barcode' => $barcode++]);
            // });
        } catch (\Throwable $th) {
            Log::error('Error during transaction: ' . $th->getMessage(), [
                'trace' => $th->getTraceAsString(),
            ]);
            throw $th;
        }
    }
}
