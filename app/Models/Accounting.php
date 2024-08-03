<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accounting extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    static function simple_time_key($time_key)
    {
        // time() dibagi dengan penjumlahan dari angka-angka pada tanggal
        // tujuannya supaya tidak terlalu panjang angka yang tercantum pada nomor surat
        
        $day = (int)date("d", $time_key);
        $month = (int)date("m", $time_key);
        $year = (int)date("Y", $time_key);
        $faktor_bagi = $day + $month + $year;
        $simple_time_key = (int)($time_key / $faktor_bagi);

        return $simple_time_key;
    }

    function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    function surat_pembelian()
    {
        return $this->hasOne(SuratPembelian::class, 'id', 'surat_pembelian_id');
    }
}
