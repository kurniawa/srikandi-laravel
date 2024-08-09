<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SuratPembelian extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    static function generate_nomor_surat($pembelian_id, $pelanggan_id, $jumlah_item, $simple_time_key)
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


        $nomor_surat = "$pembelian_id_formatted.$user_id.$kode_pelanggan.$jumlah_item_formatted-$simple_time_key";
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

    static function customer_cannot_be_user($user_id, $customer_id, $request) {
        if ($user_id == $customer_id) {
            $request->validate(['error' => 'required'], ['error.required'=>'-customer cannot be user-']);
        }
    }

    function pelanggan() {
        return $this->hasOne(User::class, 'id', 'pelanggan_id');
    }

    static function create_sp($request, $item, $time_key, $kode_accounting) {
        $post = $request->post();

        $user = Auth::user();
        $cart = null;
        if ($user) {
            $cart = Cart::where('user_id', $user->id)->first();
        }

        $hari = date("d", strtotime($time_key));
        if (isset($post['hari'])) {
            $hari = $post['hari'];
        }
        $bulan = date("m", $time_key);
        if (isset($post['bulan'])) {
            $bulan = $post['bulan'];
        }
        $tahun = date("Y", $time_key);
        if (isset($post['tahun'])) {
            $tahun = $post['tahun'];
        }
        $pelanggan_id = null;
        $pelanggan_nama = null;
        $pelanggan_username = null;
        $pelanggan_nik = null;

        // PEMBAYARAN
        $harga_total = 0;
        if (isset($post['harga_total'])) {
            $harga_total = (float)$post['harga_total'];
        } elseif (isset($post['harga_t'])) {
            $harga_total = (float)$post['harga_t'];
        }
        $total_bayar = $post['total_bayar'];
        $sisa_bayar = $post['sisa_bayar'];

        $status_bayar = 'lunas';
        if ((float)$post['sisa_bayar'] > 0.0) {
            $status_bayar = 'belum-lunas';
        }
        // END - PEMBAYARAN

        // PHOTO PATH
        $photo_path = null;
        if (isset($post['kategori']) && $post['kategori'] == "Buyback Perhiasan") {
            
        } elseif ($cart->photo_path) {
            if (Storage::exists($cart->photo_path)) {
                $exploded_filenamepath = explode("/", $cart->photo_path);
                $name_index = count($exploded_filenamepath) - 1;
                $filename = $exploded_filenamepath[$name_index];
                $photo_path = "surat_pembelians/photos/$filename";
                Storage::move($cart->photo_path, $photo_path);
            }
        }
        // END - PHOTO PATH

        $keterangan = null;
        if (isset($post['keterangan'])) {
            $keterangan = $post['keterangan'];
        } elseif ($cart && $cart->keterangan) {
            $keterangan = $cart->keterangan;
        }

        $surat_pembelian = SuratPembelian::create([
            'tanggal_surat' => date('Y-m-d', strtotime("$hari-$bulan-$tahun")) . 'T' . date('H:i:s', $time_key),
            'nomor_surat' => uniqid(),
            'time_key' => $time_key,
            'user_id' => Auth::user()->id,
            'username' => Auth::user()->username,
            'pelanggan_id' => $pelanggan_id,
            'pelanggan_nama' => $pelanggan_nama,
            'pelanggan_username' => $pelanggan_username,
            'pelanggan_nik' => $pelanggan_nik,
            'keterangan' => $keterangan,
            'harga_total' => (string)($harga_total * 100),
            'total_bayar' => (string)($total_bayar * 100),
            'sisa_bayar' => (string)($sisa_bayar * 100),
            'status_bayar' => $status_bayar,
            'photo_path' => $photo_path,
        ]);

        // GENERATE NOMOR_SURAT
        $jumlah_item = 1;
        if (isset($post['cart_item_ids'])) {
            $jumlah_item = count($post['cart_item_ids']);
        }
        $simple_time_key = Accounting::simple_time_key($time_key);
        $nomor_surat = self::generate_nomor_surat($surat_pembelian->id, $pelanggan_id, $jumlah_item, $simple_time_key);

        $surat_pembelian->nomor_surat = $nomor_surat;
        $surat_pembelian->save();
        // END - GENERATE NOMOR_SURAT

        $surat_pembelian_item = null;
        if (isset($post['cart_item_ids'])) {
            foreach ($post['cart_item_ids'] as $cart_item_id) {
                $surat_pembelian_item = SuratPembelianItem::create_surat_pembelian_item($surat_pembelian, $cart_item_id, $kode_accounting);
            }
        } elseif (isset($post['kategori']) && $post['kategori'] == "Buyback Perhiasan") {
            $surat_pembelian_item = SuratPembelianItem::buyback_create_spi($surat_pembelian, $item, $time_key);
            $surat_pembelian->tanggal_buyback = $surat_pembelian->created_at;
            $surat_pembelian->status_buyback = 'all';
            $surat_pembelian->total_buyback = $surat_pembelian->harga_total;
            $surat_pembelian->save();
        }
        return array($surat_pembelian, $surat_pembelian_item);
    }

    static function buyback_sp($surat_pembelian) {
        $surat_pembelian->update([]);
    }
}
