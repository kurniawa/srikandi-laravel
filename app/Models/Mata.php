<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mata extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::saving(function ($mata) {
    //         if ($mata->barcode) {
    //             // Cek apakah barcode mengandung angka 4
    //             if (preg_match('/4/', (string)$mata->barcode)) {
    //                 // Jika ada, tambahkan 1 pada barcode
    //                 $mata->barcode++;
    //             }
    
    //             // Simpan data
    //             $mata->save();
    //         }
    //     });
    // }
}
