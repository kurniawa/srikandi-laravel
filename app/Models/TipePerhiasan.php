<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipePerhiasan extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::saving(function ($tipe_perhiasan) {
    //         if ($tipe_perhiasan->barcode) {
    //             // Cek apakah barcode mengandung angka 4
    //             if (preg_match('/4/', (string)$tipe_perhiasan->barcode)) {
    //                 // Jika ada, tambahkan 1 pada barcode
    //                 $tipe_perhiasan->barcode++;
    //             }
    
    //             // Simpan data
    //             $tipe_perhiasan->save();
    //         }
    //     });
    // }
}
