<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cashflow extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($cashflow) {
            while (DB::table('cashflows')
                ->where('cashflow_date', $cashflow->cashflow_date)
                ->exists()) {
                $cashflow->cashflow_date = date('Y-m-d H:i:s', strtotime($cashflow->cashflow_date) + 1);
            }
        });
    }

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
        // dd($post);
        if (!isset($post['kategori_wallet']) || !isset($post['tipe_wallet']) || !isset($post['nama_wallet']) || !isset($post['jumlah_pembayaran'])) {
            $request->validate(['error'=>'required'],['error.required'=>'post data wallet not exist']);
        }
        // $jumlah_pembayaran = 0;
        $request->validate([
            'jumlah_pembayaran' => 'array',
            'jumlah_pembayaran.*' => 'nullable|numeric',
            'kategori_wallet' => 'array',
            'tipe_wallet' => 'array',
            'nama_wallet' => 'array',
        ]);
        // for ($i=0; $i < count($post['jumlah_pembayaran']); $i++) { 
        //     $jumlah_pembayaran += (float)$post['jumlah_pembayaran'][$i];
        // }

        // $total_tagihan = "";
        if ($post['kategori'] == "Buyback Perhiasan") {
            if (!isset($post['harga_t']) || $post['harga_t'] == null) {
                $request->validate([
                    'harga_terima'=>'required'
                ]);
            }
            // $total_tagihan = $post['harga_terima'];
        } elseif ($post['kategori'] == "Penjualan Perhiasan") {
            if (!isset($post['harga_total']) || $post['harga_total'] == null) {
                $request->validate(['error'=>'required'],['error.required'=>'Harus ada harga_total']);
            }
            // $total_tagihan = $post['harga_total'];
        } else {
            if (!isset($post['total_tagihan']) || $post['total_tagihan'] == null) {
                $request->validate(['error'=>'required'],['error.required'=>'Harus ada total_tagihan']);
            }
            // $total_tagihan = $post['total_tagihan'];
        }

        // dump("harga_t atau total_tagihan");
        // dump($total_tagihan);
        // dump((float)$total_tagihan);
        // dump("jumlah_pembayaran");
        // dd($jumlah_pembayaran);
        // if ($jumlah_pembayaran !== (float)$total_tagihan) {
        //     dump("post[harga_total]");
        //     dump($total_tagihan);
        //     dump((float)$total_tagihan);
        //     dump("jumlah_pembayaran");
        //     dd($jumlah_pembayaran);
        // }

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

    static function create_cashflow($params) {
        $user_id = $params['user_id'];
        $time_key = $params['time_key'];
        $kode_accounting = $params['kode_accounting'];
        $surat_pembelian_id = $params['surat_pembelian_id'];
        $post = $params['post'];
        $cashflow_date = $params['cashflow_date'];
        $is_earlier_date = $params['is_earlier_date'];

        $jumlah_terima_total = 0.0;
        // $cashflow_time = strtotime($cashflow_date);
        // $incremented_cashflow_date = $cashflow_time;

        foreach ($post['kategori_wallet'] as $key => $kategori_wallet) {
            if ($post['jumlah_pembayaran'][$key]) {
                // Ambil wallet
                $wallet = Wallet::where('kategori_wallet', $kategori_wallet)
                    ->where('tipe_wallet', $post['tipe_wallet'][$key])
                    ->where('nama_wallet', $post['nama_wallet'][$key])
                    ->first();

                // // Pastikan cashflow_date unik
                // while (Cashflow::where('kategori_wallet', $wallet->kategori_wallet)
                //     ->where('tipe_wallet', $wallet->tipe_wallet)
                //     ->where('nama_wallet', $wallet->nama_wallet)
                //     ->where('cashflow_date', '=', date('Y-m-d\TH:i:s', $incremented_cashflow_date))
                //     ->exists()) {
                //     $incremented_cashflow_date = strtotime('+1 second', $incremented_cashflow_date);
                // }
                // $cashflow_date = date('Y-m-d\TH:i:s', $incremented_cashflow_date);

                // Ambil cashflows setelah cashflow_date jika perlu
                $latest_cashflows = collect();
                $cashflow_before = null;

                if ($is_earlier_date) {
                    $cashflow_before = Cashflow::where('kategori_wallet', $wallet->kategori_wallet)
                        ->where('tipe_wallet', $wallet->tipe_wallet)
                        ->where('nama_wallet', $wallet->nama_wallet)
                        ->where('cashflow_date', '<', $cashflow_date)
                        ->orderByDesc('cashflow_date')->first();

                    $latest_cashflows = Cashflow::where('kategori_wallet', $wallet->kategori_wallet)
                        ->where('tipe_wallet', $wallet->tipe_wallet)
                        ->where('nama_wallet', $wallet->nama_wallet)
                        ->where('cashflow_date', '>', $cashflow_date)
                        ->orderBy('cashflow_date')->get();
                } else {
                    $cashflow_before = Cashflow::where('kategori_wallet', $wallet->kategori_wallet)
                        ->where('tipe_wallet', $wallet->tipe_wallet)
                        ->where('nama_wallet', $wallet->nama_wallet)
                        ->orderByDesc('cashflow_date')->first();
                }

                $saldo_akhir = $cashflow_before ? $cashflow_before->saldo : 0.0;
                $transaksi = (float) $post['jumlah_pembayaran'][$key];

                $saldo_akhir += $post['tipe_transaksi'] == 'pemasukan' ? $transaksi : -$transaksi;

                // Buat cashflow baru
                $cashflow = Cashflow::create([
                    'user_id' => $user_id,
                    'time_key' => $time_key,
                    'kode_accounting' => $kode_accounting,
                    'surat_pembelian_id' => $surat_pembelian_id,
                    'tipe' => $post['tipe_transaksi'],
                    'kategori_wallet' => $wallet->kategori_wallet,
                    'tipe_wallet' => $wallet->tipe_wallet,
                    'nama_wallet' => $wallet->nama_wallet,
                    'jumlah' => $transaksi,
                    'saldo' => $saldo_akhir,
                    'cashflow_date' => $cashflow_date,
                ]);

                // Update saldo pada cashflows berikutnya
                foreach ($latest_cashflows as $latest_cashflow) {
                    $saldo_akhir += $latest_cashflow->tipe == 'pemasukan' ? $latest_cashflow->jumlah : -$latest_cashflow->jumlah;
                    $latest_cashflow->update(['saldo' => $saldo_akhir]);
                }

                // Update saldo pada wallet
                $wallet->update(['saldo' => $saldo_akhir]);

                $jumlah_terima_total += $transaksi;
            }
            // $incremented_cashflow_date = strtotime('+1 second', $incremented_cashflow_date);
        }

        return $jumlah_terima_total;
    }

    static function set_date_time($post) {
        $time_key = time();
        $timestamp_now = date('Y-m-d', $time_key) . 'T' . date('H:i:s', $time_key);
        $accounting_date = $timestamp_now;
        $is_earlier_date = false;
        if (isset($post['hari']) && isset($post['bulan']) && isset($post['tahun'])) {
            if (is_numeric($post['hari']) && is_numeric($post['bulan']) && is_numeric($post['tahun'])) {
                $accounting_date = date('Y-m-d', strtotime("$post[hari]-$post[bulan]-$post[tahun]")) . 'T' . date('H:i:s', $time_key);
            } 
        }

        if ($accounting_date < $timestamp_now) {
            $is_earlier_date = true;
        }

        $cashflow_date = $accounting_date;

        return [
            "timestamp_now" => $timestamp_now,
            "time_key" => $time_key,
            "accounting_date" => $accounting_date,
            "cashflow_date" => $cashflow_date,
            "is_earlier_date" => $is_earlier_date,
        ];
    }
    
}
