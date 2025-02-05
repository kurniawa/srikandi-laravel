<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarnaEmas extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::saving(function ($warna_emas) {
    //         if ($warna_emas->barcode) {
    //             // Cek apakah barcode mengandung angka 4
    //             if (preg_match('/4/', (string)$warna_emas->barcode)) {
    //                 // Jika ada, tambahkan 1 pada barcode
    //                 $warna_emas->barcode++;
    //             }
    
    //             // Simpan data
    //             $warna_emas->save();
    //         }
    //     });
    // }
}
