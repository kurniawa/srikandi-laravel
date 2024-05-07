<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saldo extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    static function cek_saldo_wallet_sebelumnya_dan_create_apabila_belum_ada($time_key, $wallet, $jumlah) {
        $jumlah_saldo = 0;
        $saldo = Saldo::where('created_at', date("Y-m-d", $time_key))->where('kategori_wallet', $wallet->kategori)->where('tipe_wallet', $wallet->tipe)->where('nama_wallet', $wallet->nama)->first();
        if (!$saldo) {
            $saldo_yesterday = Saldo::where('created_at', date("Y-m-d", $time_key - 86400))->where('kategori_wallet', $wallet->kategori)->where('tipe_wallet', $wallet->tipe)->where('nama_wallet', $wallet->nama)->first();
            if ($saldo_yesterday) {
                $jumlah_saldo = (int)$saldo_yesterday->jumlah + $jumlah;
            } else {
                $jumlah_saldo = $jumlah;
            }

        } else {
            $jumlah_saldo = (int)$saldo->jumlah + $jumlah;
        }
        $saldo = Saldo::create([
            "kategori_wallet" => $wallet->kategori,
            "tipe_wallet" => $wallet->tipe,
            "nama_wallet" => $wallet->nama,
            "saldo" => (string)$jumlah_saldo,
        ]);
    }
}
