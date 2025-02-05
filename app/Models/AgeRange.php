<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgeRange extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::saving(function ($age_range) {
    //         if ($age_range->barcode) {
    //             // Cek apakah barcode mengandung angka 4
    //             if (preg_match('/4/', (string)$age_range->barcode)) {
    //                 // Jika ada, tambahkan 1 pada barcode
    //                 $age_range->barcode++;
    //             }
    
    //             // Simpan data
    //             $age_range->save();
    //         }
    //     });
    // }
}
