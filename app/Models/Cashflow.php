<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cashflow extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    function user()
    {
        return $this->hasOne(User::class, "id", "user_id");
    }

    function surat_pembelian()
    {
        return $this->hasOne(SuratPembelian::class, 'id', 'surat_pembelian_id');
    }

    function accounting()
    {
        $accounting = Accounting::where('kode_accounting', $this->kode_accounting)->first();
        return $accounting;
    }

    static function create_cashflow($user_id, $time_key, $kode_accounting, $pembelian_id, $tipe_transaksi, $jumlah_tunai, $sisa_bayar, $jumlah_non_tunai, $tipe_instansis, $nama_instansis)
    {
        // CASHFLOW
        $jumlah = 0;
        $jumlah_terima_total = 0;
        if ($jumlah_tunai) {
            if ((int)$sisa_bayar < 0) {
                $jumlah = ((float)$jumlah_tunai + (float)$sisa_bayar) * 100;
            } else {
                $jumlah = (float)$jumlah_tunai * 100;
            }
            $wallet = Wallet::where('tipe', 'laci')->where('nama', 'cash')->first();
            $cashflow_sebelum = Cashflow::where('kategori_wallet', $wallet->kategori)->where('tipe_wallet', $wallet->tipe)->where('nama_wallet', $wallet->nama)->latest()->first();
            $saldo_akhir = (int)$cashflow_sebelum->saldo * 100;
            if ($tipe_transaksi == 'pemasukan') {
                $saldo_akhir += $jumlah;
            } elseif ($tipe_transaksi == 'pengeluaran') {
                $saldo_akhir -= $jumlah;
            }
            $cashflow = Cashflow::create([
                'user_id' => $user_id,
                'time_key' => $time_key,
                'kode_accounting' => $kode_accounting,
                'surat_pembelian_id' => $pembelian_id,
                // 'surat_pembelian_item_id' => $surat_pembelian_item->id,
                // 'nama_transaksi' => $nama_transaksi,
                'tipe' => $tipe_transaksi,
                'kategori_wallet' => $wallet->kategori,
                'tipe_wallet' => $wallet->tipe,
                'nama_wallet' => $wallet->nama,
                'jumlah' => $jumlah,
                'saldo' => $saldo_akhir,
            ]);
            // self::create_update_neraca($tipe_wallet, $nama_wallet, $jumlah);

            // CEK Saldo terkait

            // Saldo::cek_saldo_wallet_sebelumnya_dan_create_apabila_belum_ada($time_key, $wallet, $jumlah);
        }
        $jumlah_terima_total += $jumlah;

        if ($jumlah_non_tunai) { // kodingan pada blade sempat di edit, js dipake bareng2, awalnya ini namanya jumlah_non_tunai
            foreach ($jumlah_non_tunai as $key => $jumlah_nt) {
                if ($jumlah_nt !== null) {
                    $wallet = Wallet::where('tipe', $tipe_instansis[$key])->where('nama', $nama_instansis[$key])->first();
                    // $tipe_wallet = $post['tipe_instansi'][$key];
                    // $nama_wallet = $post['nama_instansi'][$key];
                    $jumlah = $jumlah_nt * 100;
                    $saldo_akhir = (int)$cashflow_sebelum->saldo * 100;
                    if ($tipe_transaksi == 'pemasukan') {
                        $saldo_akhir += $jumlah;
                    } elseif ($tipe_transaksi == 'pengeluaran') {
                        $saldo_akhir -= $jumlah;
                    }
                    $cashflow = Cashflow::create([
                        'user_id' => $user_id,
                        'time_key' => $time_key,
                        'kode_accounting' => $kode_accounting,
                        'surat_pembelian_id' => $pembelian_id,
                        // 'nama_transaksi' => $nama_transaksi,
                        'tipe' => $tipe_transaksi,
                        'kategori_wallet' => $wallet->kategori,
                        'tipe_wallet' => $wallet->tipe,
                        'nama_wallet' => $wallet->nama,
                        'saldo' => $saldo_akhir,
                    ]);
                    // self::create_update_neraca($tipe_wallet, $nama_wallet, $jumlah);
                    // Saldo::cek_saldo_wallet_sebelumnya_dan_create_apabila_belum_ada($time_key, $wallet, $jumlah);
                    $jumlah_terima_total += $jumlah;
                }
            }
        }
        return $jumlah_terima_total;
        // END - CASHFLOW
    }
}
