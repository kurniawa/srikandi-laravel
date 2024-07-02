<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserKontak extends Model
{
    use HasFactory;
    protected $guarded = ["id"];

    static function create_new_kontak($post, $user, $skip_check)
    {
        if ($skip_check) {
            UserKontak::create([
                "user_id" => $user->id,
                "tipe" => "WA",
                "nomor" => $post["nomor_wa"],
                "is_aktual" => "yes",
            ]);
        } else {
            if (isset($post["nomor_wa"])) {
                UserKontak::create([
                    "user_id" => $user->id,
                    "tipe" => "WA",
                    "nomor" => $post["nomor_wa"],
                    "is_aktual" => "yes",
                ]);
            }
        }
    }

    static function update_kontak($post, $user)
    {
        if (isset($post["nomor_wa"])) {
            if (count($user->kontaks)) {
                $user->kontaks[0]->update([
                    "user_id" => $user->id,
                    "tipe" => "WA",
                    "nomor" => $post["nomor_wa"],
                    "is_aktual" => "yes",
                ]);
            } else {
                static::create_new_kontak($post, $user, true);
            }
        }
    }
}
