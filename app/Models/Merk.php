<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Merk extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::saving(function ($merk) {
    //         if ($merk->barcode) {
    //             // Cek apakah barcode mengandung angka 4
    //             if (preg_match('/4/', (string)$merk->barcode)) {
    //                 // Jika ada, tambahkan 1 pada barcode
    //                 $merk->barcode++;
    //             }
    
    //             // Simpan data
    //             $merk->save();
    //         }
    //     });
    // }
}
