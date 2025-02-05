<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mainan extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::saving(function ($mainan) {
    //         if ($mainan->barcode) {
    //             // Cek apakah barcode mengandung angka 4
    //             if (preg_match('/4/', (string)$mainan->barcode)) {
    //                 // Jika ada, tambahkan 1 pada barcode
    //                 $mainan->barcode++;
    //             }
    
    //             // Simpan data
    //             $mainan->save();
    //         }
    //     });
    // }

    static function generate_codename_from_nama($nama) {
        if (str_contains($nama, " ")) {
            $arr_nama = explode(" ", $nama);
            for ($i=0; $i < count($arr_nama); $i++) { 
                $arr_nama[$i] = ucfirst($arr_nama[$i]);
            }
            $new_nama = implode(" ", $arr_nama);
            $codename = "m-" . str_replace(" ", "", $new_nama);
            $nama = $new_nama;
        } else {
            $nama = ucfirst($nama);
            $codename = "m-$nama";
        }
        return array($nama, $codename);
    }
}
