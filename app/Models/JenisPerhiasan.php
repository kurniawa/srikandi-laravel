<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisPerhiasan extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::saving(function ($jenis_perhiasan) {
    //         if ($jenis_perhiasan->barcode) {
    //             // Cek apakah barcode mengandung angka 4
    //             if (preg_match('/4/', (string)$jenis_perhiasan->barcode)) {
    //                 // Jika ada, tambahkan 1 pada barcode
    //                 $jenis_perhiasan->barcode++;
    //             }
    
    //             // Simpan data
    //             $jenis_perhiasan->save();
    //         }
    //     });
    // }

    static function check_and_create($tipe_perhiasan_id, $tipe_perhiasan_nama, $jenis_perhiasan_nama) {
        $tipe_perhiasan = collect();

        if ($tipe_perhiasan_id) {
            $tipe_perhiasan = TipePerhiasan::find($tipe_perhiasan_id);
        } else {
            $tipe_perhiasan = TipePerhiasan::where('nama', $tipe_perhiasan_nama)->first();
        }

        $exist_jenis_perhiasan = JenisPerhiasan::where('tipe_perhiasan', $tipe_perhiasan_nama)->where('nama', $jenis_perhiasan_nama)->first();
        
        if (!$exist_jenis_perhiasan) {
            $last_barcode = JenisPerhiasan::select('barcode')->where('tipe_perhiasan', $tipe_perhiasan_nama)->orderByDesc('barcode')->first();
            $barcode = $last_barcode->barcode;
            // Menghindari angka 4 pada barcode
            $barcode = str_contains('4', (string)$barcode) ? ($barcode + 1) : $barcode;
            JenisPerhiasan::create([
                'tipe_perhiasan_id' => $tipe_perhiasan->id,
                'tipe_perhiasan' => $tipe_perhiasan->nama,
                'nama' => $jenis_perhiasan_nama,
                'barcode' => $barcode,
            ]);
        }
    }
}
