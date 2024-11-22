<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mainan extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

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
