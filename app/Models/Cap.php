<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cap extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::saving(function ($cap) {
    //         if ($cap->barcode) {
    //             // Cek apakah barcode mengandung angka 4
    //             if (preg_match('/4/', (string)$cap->barcode)) {
    //                 // Jika ada, tambahkan 1 pada barcode
    //                 $cap->barcode++;
    //             }
    
    //             // Simpan data
    //             $cap->save();
    //         }
    //     });
    // }
}
