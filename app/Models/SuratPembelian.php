<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class SuratPembelian extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    static function generate_nomor_surat($pembelian_id, $pelanggan_id, $jumlah_item, $time_key)
    {
        // $time = time();
        // $last_four_digit = substr(strval($time),-4);
        // $time_key = $time - (int)$last_four_digit;
        // dump($last_four_digit);
        // dd($time_key);
        // $length = 3;
        // $randomString = substr(str_shuffle("abcdefghijklmnopqrstuvwxyz"),0,$length);
        // dump($randomString);
        // dump(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"));
        // dump(substr("abcdefghijklmnopqrstuvwxyz", mt_rand(0, 25), 1).substr(md5(time()), 1));
        // dump(Str::uuid());
        // dump(Str::random(3));
        // dump(time());
        // dd(time()-1678420000);
        // $time = time();
        // $last_four_digit = substr(strval($time),-4);
        // $time_key = $time - (int)$last_four_digit;
        $pembelian_id_formatted = $pembelian_id;
        if (strlen((string)$pembelian_id) === 1) {
            $pembelian_id_formatted = "0$pembelian_id";
        }
        $user = Auth::user();
        $user_id = $user->id;
        if (strlen((string)$user->id) === 1) {
            $user_id = "0$user->id";
        }
        $kode_pelanggan = $pelanggan_id;
        if (!$kode_pelanggan) {
            $kode_pelanggan = '00';
        }
        if (strlen((string)$kode_pelanggan) === 1) {
            $kode_pelanggan = "0$kode_pelanggan";
        }
        $jumlah_item_formatted = $jumlah_item;
        if (strlen((string)$jumlah_item) === 1) {
            $jumlah_item_formatted = "0$jumlah_item";
        }
        $day = (int)date("d", $time_key);
        $month = (int)date("m", $time_key);
        $year = (int)date("Y", $time_key);
        $faktor_bagi = $day + $month + $year;
        $nomor_surat = (int)($time_key / $faktor_bagi);

        $nomor_surat = "$pembelian_id_formatted.$user_id.$kode_pelanggan.$jumlah_item_formatted-$nomor_surat";
        // terdiri dari tiga bagian 11.22.33 -> nomor surat juga harusnya akan selalu unik

        // return array($nomor_surat, $time_key);
        return $nomor_surat;
        // dump($last_four_digit);
        // dd($time_key);
    }

    function items() {
        return $this->hasMany(SuratPembelianItem::class);
    }

    function cashflows() {
        return $this->hasMany(Cashflow::class);
    }

    function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
