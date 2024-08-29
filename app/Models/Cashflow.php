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

    static function validasi_metode_pembayaran($request) {
        $post = $request->post();
        if (!isset($post['jumlah_tunai']) && !isset($post['jumlah_non_tunai'])) {
            $request->validate(['error'=>'required'],['error.required'=>'post jumlah_tunai or jumlah_non_tunai not exist']);
        }
        $jumlah_tunai = 0;
        if (isset($post['jumlah_tunai'])) {
            if ($post['jumlah_tunai']) {
                $jumlah_tunai += (float)$post['jumlah_tunai'];
            }
        }
        $jumlah_non_tunai = 0;
        if (isset($post['jumlah_non_tunai'])) {
            $request->validate([
                'jumlah_non_tunai' => 'array',
                'jumlah_non_tunai.*' => 'nullable|numeric',
                'nama_instansi' => 'array',
                'tipe_instansi' => 'array',
            ]);
            for ($i=0; $i < count($post['jumlah_non_tunai']); $i++) { 
                $jumlah_non_tunai += (float)$post['jumlah_non_tunai'][$i];
            }
        }

        $jumlah_pembayaran = $jumlah_tunai + $jumlah_non_tunai;
        $total_tagihan = "";
        if ($post['kategori'] == "Buyback Perhiasan") {
            if (!isset($post['harga_t']) || $post['harga_t'] == null) {
                $request->validate(['error'=>'required'],['error.required'=>'Buyback Perhiasan harus ada harga_t']);
            }
            $total_tagihan = $post['harga_t'];
        } elseif ($post['kategori'] == "Penjualan Perhiasan") {
            if (!isset($post['harga_total']) || $post['harga_total'] == null) {
                $request->validate(['error'=>'required'],['error.required'=>'Harus ada harga_total']);
            }
            $total_tagihan = $post['harga_total'];
        } else {
            if (!isset($post['total_tagihan']) || $post['total_tagihan'] == null) {
                $request->validate(['error'=>'required'],['error.required'=>'Harus ada total_tagihan']);
            }
            $total_tagihan = $post['total_tagihan'];
        }

        // dump("harga_t atau total_tagihan");
        // dump($total_tagihan);
        // dump((float)$total_tagihan);
        // dump("jumlah_pembayaran");
        // dd($jumlah_pembayaran);
        if ($jumlah_pembayaran !== (float)$total_tagihan) {
            dump("post[harga_total]");
            dump($total_tagihan);
            dump((float)$total_tagihan);
            dump("jumlah_pembayaran");
            dd($jumlah_pembayaran);
        }

        return true;
    }

    static function add_data_metode_pembayaran($request, $data) {
        $post = $request->post();
        if (isset($post['jumlah_tunai'])) {
            $data['jumlah_tunai'] = $post['jumlah_tunai'];
        }

        if (isset($post['jumlah_non_tunai'])) {
            $data['jumlah_non_tunai'] = $post['jumlah_non_tunai'];
            $data['nama_instansi'] = $post['nama_instansi'];
            $data['tipe_instansi'] = $post['tipe_instansi'];
        }

        $data['total_bayar'] = $post['total_bayar'];
        $data['sisa_bayar'] = $post['sisa_bayar'];

        return $data;
    }

    static function create_cashflow($user_id, $time_key, $kode_accounting, $pembelian_id, $post)
    {
        // CASHFLOW
        // $total_tagihan = 0; // harga_total sinonim dnegan total_tagihan
        // if (isset($post['harga_total'])) {
        //     $total_tagihan = (float)$post['harga_total'];
        // } elseif (isset($post['total_tagihan'])) {
        //     $total_tagihan = (float)$post['total_tagihan'];
        // }
        // $total_bayar = (float)$post['total_bayar'];
        $sisa_bayar = (float)$post['sisa_bayar'];
        // $sisa_bayar = 0;
        // try {
        //     $sisa_bayar = (float)$post['sisa_bayar'];
        // } catch (\Throwable $th) {
        //     dump($sisa_bayar);
        //     dump($post['sisa_bayar']);
        // }

        $jumlah_tunai = null;
        $jumlah_non_tunai = null;
        $tipe_instansis = null;
        $nama_instansis = null;
        if (isset($post['jumlah_tunai'])) {
            $jumlah_tunai = $post['jumlah_tunai'];
        }
        if (isset($post['jumlah_non_tunai'])) {
            $jumlah_non_tunai = $post['jumlah_non_tunai'];
            $tipe_instansis = $post['tipe_instansi'];
            $nama_instansis = $post['nama_instansi'];
        }

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
            $saldo_akhir = 0;
            if ($cashflow_sebelum) {
                $saldo_akhir = (int)$cashflow_sebelum->saldo;
            }
            if ($post['tipe_transaksi'] == 'pemasukan') {
                $saldo_akhir += $jumlah;
            } elseif ($post['tipe_transaksi'] == 'pengeluaran') {
                $saldo_akhir -= $jumlah;
            }
            $cashflow = Cashflow::create([
                'user_id' => $user_id,
                'time_key' => $time_key,
                'kode_accounting' => $kode_accounting,
                'surat_pembelian_id' => $pembelian_id,
                // 'surat_pembelian_item_id' => $surat_pembelian_item->id,
                // 'nama_transaksi' => $nama_transaksi,
                'tipe' => $post['tipe_transaksi'],
                'kategori_wallet' => $wallet->kategori,
                'tipe_wallet' => $wallet->tipe,
                'nama_wallet' => $wallet->nama,
                'jumlah' => (string)$jumlah,
                'saldo' => (string)$saldo_akhir,
            ]);
            $wallet = Wallet::where('nama', $cashflow->nama_wallet)->first();
            $wallet->saldo = (string)$saldo_akhir;
            $wallet->save();
            // self::create_update_neraca($tipe_wallet, $nama_wallet, $jumlah);

            // CEK Saldo terkait

            // Saldo::cek_saldo_wallet_sebelumnya_dan_create_apabila_belum_ada($time_key, $wallet, $jumlah);
        }
        $jumlah_terima_total += $jumlah;

        if ($jumlah_non_tunai) { // kodingan pada blade sempat di edit, js dipake bareng2, awalnya ini namanya jumlah_non_tunai
            foreach ($jumlah_non_tunai as $key => $jumlah_nt) {
                if ($jumlah_nt !== null) {
                    $wallet = Wallet::where('tipe', $tipe_instansis[$key])->where('nama', $nama_instansis[$key])->first();
                    $cashflow_sebelum = Cashflow::where('kategori_wallet', $wallet->kategori)->where('tipe_wallet', $wallet->tipe)->where('nama_wallet', $wallet->nama)->latest()->first();
                    // $tipe_wallet = $post['tipe_instansi'][$key];
                    // $nama_wallet = $post['nama_instansi'][$key];
                    $jumlah = $jumlah_nt * 100;
                    $saldo_akhir = 0;
                    if ($cashflow_sebelum) {
                        $saldo_akhir = (int)$cashflow_sebelum->saldo;
                    }
                    if ($post['tipe_transaksi'] == 'pemasukan') {
                        $saldo_akhir += $jumlah;
                    } elseif ($post['tipe_transaksi'] == 'pengeluaran') {
                        $saldo_akhir -= $jumlah;
                    }
                    $cashflow = Cashflow::create([
                        'user_id' => $user_id,
                        'time_key' => $time_key,
                        'kode_accounting' => $kode_accounting,
                        'surat_pembelian_id' => $pembelian_id,
                        // 'nama_transaksi' => $nama_transaksi,
                        'tipe' => $post['tipe_transaksi'],
                        'kategori_wallet' => $wallet->kategori,
                        'tipe_wallet' => $wallet->tipe,
                        'nama_wallet' => $wallet->nama,
                        'jumlah' => (string)$jumlah,
                        'saldo' => (string)$saldo_akhir,
                    ]);
                    
                    $wallet = Wallet::where('nama', $cashflow->nama_wallet)->first();
                    $wallet->saldo = (string)$saldo_akhir;
                    $wallet->save();
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
