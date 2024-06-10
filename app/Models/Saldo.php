<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saldo extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    static function cek_saldo_wallet_sebelumnya_dan_create_apabila_belum_ada($time_key, $wallet, $jumlah) {
        $saldo_akhir = $jumlah;
        $saldo_awal = 0;
        $today = date("Y-m-d", $time_key);
        $saldo_today = Saldo::whereBetween('created_at', [$today, date("Y-m-d H:i:s", $time_key)])->where('kategori_wallet', $wallet->kategori)->where('tipe_wallet', $wallet->tipe)->where('nama_wallet', $wallet->nama)->first();
        if (!$saldo_today) {
            $yesterday = date("Y-m-d", $time_key - 86400);
            $saldo_yesterday = Saldo::whereBetween('created_at', [$yesterday, date("Y-m-d H:i:s", $time_key)])->where('kategori_wallet', $wallet->kategori)->where('tipe_wallet', $wallet->tipe)->where('nama_wallet', $wallet->nama)->first();
            if ($saldo_yesterday) {
                $saldo_akhir = (int)$saldo_yesterday->saldo_akhir + $jumlah;
                $saldo_awal = $saldo_yesterday->saldo_akhir;
            }

        } else {
            $saldo_akhir = (int)$saldo_today->saldo_akhir + $jumlah;
        }
        $saldo = Saldo::create([
            "kategori_wallet" => $wallet->kategori,
            "tipe_wallet" => $wallet->tipe,
            "nama_wallet" => $wallet->nama,
            "saldo_awal" => (string)$saldo_awal,
            "saldo_akhir" => (string)$saldo_akhir,
        ]);
        // $saldo_awal = 0;
        // $saldo_akhir = $jumlah;
        // $last_saldo = Saldo::where('kategori_wallet', $wallet->kategori)->where('tipe_wallet', $wallet->tipe)->where('nama_wallet', $wallet->nama)->latest()->first();
        // if ($last_saldo) {
        //     $saldo_awal = (int)$last_saldo->saldo_akhir;
        //     $saldo_akhir = $saldo_awal + $jumlah;
        // }
        // $saldo = Saldo::create([
        //     "kategori_wallet" => $wallet->kategori,
        //     "tipe_wallet" => $wallet->tipe,
        //     "nama_wallet" => $wallet->nama,
        //     "saldo_awal" => (string)$saldo_awal,
        //     "saldo_akhir" => (string)$saldo_akhir,
        // ]);
    }
}
