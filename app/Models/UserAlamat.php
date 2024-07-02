<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAlamat extends Model
{
    use HasFactory;
    protected $guarded = ["id"];

    static function create_new_alamat($post, $user, $skip_check)
    {
        if ($skip_check) {
            UserAlamat::create([
                "user_id" => $user->id,
                "tipe" => "UTAMA",
                "alamat_baris_1" => $post["alamat_baris_1"],
                "alamat_baris_2" => $post["alamat_baris_2"],
                "alamat_baris_3" => $post["alamat_baris_3"],
                "provinsi" => $post["provinsi"],
                "kota" => $post["kota"],
                "kodepos" => $post["kodepos"],
            ]);
        } else {
            if (isset($post['alamat_baris_1']) || isset($post['alamat_baris_2']) || isset($post['alamat_baris_3']) || isset($post['provinsi']) || isset($post['kota']) || isset($post['kodepos'])) {
                UserAlamat::create([
                    "user_id" => $user->id,
                    "tipe" => "UTAMA",
                    "alamat_baris_1" => $post["alamat_baris_1"],
                    "alamat_baris_2" => $post["alamat_baris_2"],
                    "alamat_baris_3" => $post["alamat_baris_3"],
                    "provinsi" => $post["provinsi"],
                    "kota" => $post["kota"],
                    "kodepos" => $post["kodepos"],
                ]);
            }
        }
    }

    static function update_alamat($post, $user)
    {
        if (isset($post['alamat_baris_1']) || isset($post['alamat_baris_2']) || isset($post['alamat_baris_3']) || isset($post['provinsi']) || isset($post['kota']) || isset($post['kodepos'])) {
            if (count($user->alamats)) {
                $user->alamats[0]->update([
                    "alamat_baris_1" => $post["alamat_baris_1"],
                    "alamat_baris_2" => $post["alamat_baris_2"],
                    "alamat_baris_3" => $post["alamat_baris_3"],
                    "provinsi" => $post["provinsi"],
                    "kota" => $post["kota"],
                    "kodepos" => $post["kodepos"],
                ]);
            } else {
                static::create_new_alamat($post, $user, true);
            }
        }
    }
}
