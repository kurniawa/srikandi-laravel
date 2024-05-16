<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Photo extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public $timestamps = false;

    static function cek_photo_path($folder, $extension) {
        $time = time();
        $file_exist = true;
        $file_name = "";
        $photo_path = "";
        while ($file_exist) {
            $file_name = $time . "." . $extension;
            $photo_path = "$folder/$file_name";

            if (Storage::exists($photo_path)) {
                $time++;
            } else {
                $file_exist = false;
            }
        }

        return array($file_name, $photo_path);
    }
}
