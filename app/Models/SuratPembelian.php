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

    static function generate_nomor_surat($params)
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
        $user_id = $params['user_id'];
        $surat_pembelian_id = $params['surat_pembelian_id'];
        $pelanggan_id = $params['pelanggan_id'];
        $jumlah_item = $params['jumlah_item'];
        $simple_time_key = $params['simple_time_key'];

        $surat_pembelian_id_formatted = $surat_pembelian_id;
        if (strlen((string)$surat_pembelian_id) === 1) {
            $surat_pembelian_id_formatted = "0$surat_pembelian_id";
        }
        if (strlen((string)$user_id) === 1) {
            $user_id = "0$user_id";
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


        $nomor_surat = "$surat_pembelian_id_formatted.$user_id.$kode_pelanggan.$jumlah_item_formatted-$simple_time_key";
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

    static function create_sp($data) {
        $item = $data['item'];
        $post = $data['post'];
        $user = $data['user'];

        $cart = null;
        if ($user) {
            $cart = Cart::where('user_id', $user->id)->first();
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
        $berat_buyback = null;
        $total_potongan = null;
        $harga_terima = null;
        $berat_susut = 'tidak';
        $total_buyback = null;

        if (isset($post['kategori']) && $post['kategori'] == "Buyback Perhiasan") {
            $berat_buyback = (float)$post['berat_terima'];
            $total_potongan = (float)$post['total_potongan'];
            $harga_terima = (float)$post['harga_terima'];
            if ($berat_buyback < $item->berat) {
                $berat_susut = 'ya';
            }
            $total_buyback = $harga_terima;
            
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
            'tanggal_surat' => $data['tanggal_surat'],
            'nomor_surat' => uniqid(),
            'time_key' => $data['time_key'],
            'user_id' => $user->id,
            'username' => $user->username,
            'pelanggan_id' => $pelanggan_id,
            'pelanggan_nama' => $pelanggan_nama,
            'pelanggan_username' => $pelanggan_username,
            'pelanggan_nik' => $pelanggan_nik,
            'keterangan' => $keterangan,
            'harga_total' => $harga_total,
            'total_bayar' => $total_bayar,
            'sisa_bayar' => $sisa_bayar,
            'total_buyback' => $total_buyback,
            'status_bayar' => $status_bayar,
            'photo_path' => $photo_path,
        ]);

        // GENERATE NOMOR_SURAT
        $jumlah_item = 1;
        if (isset($post['cart_item_ids'])) {
            $jumlah_item = count($post['cart_item_ids']);
        }
        $simple_time_key = Accounting::simple_time_key($data['time_key']);
        $nomor_surat = self::generate_nomor_surat($user, $surat_pembelian->id, $pelanggan_id, $jumlah_item, $simple_time_key);

        $surat_pembelian->nomor_surat = $nomor_surat;
        $surat_pembelian->save();
        // END - GENERATE NOMOR_SURAT

        $surat_pembelian_item = null;
        if (isset($post['cart_item_ids'])) {
            foreach ($post['cart_item_ids'] as $cart_item_id) {
                $data_create_spi = [
                    'user' => $user,
                    'surat_pembelian' => $surat_pembelian,
                    'cart_item_id' => $cart_item_id,
                    'kode_accounting' => $data['kode_accounting'],
                ];
                $surat_pembelian_item = SuratPembelianItem::create_surat_pembelian_item($data_create_spi);
            }
        } elseif (isset($post['kategori']) && $post['kategori'] == "Buyback Perhiasan") {
            // SP pada saat pelanggan menjual, namun surat biasa, belum masuk ke dalam sistem.
            $data_bb_create_spi = [
                'surat_pembelian' => $surat_pembelian,
                'item' => $item,
                'time_key' => $data['time_key'],
            ];
            $surat_pembelian_item = SuratPembelianItem::buyback_create_spi($data_bb_create_spi);
            $surat_pembelian->tanggal_buyback = $surat_pembelian->created_at;
            $surat_pembelian->status_buyback = 'all';
            $surat_pembelian->save();

            $surat_pembelian_item->berat_susut = $berat_susut;
            $surat_pembelian_item->berat_buyback = $berat_buyback;
            $surat_pembelian_item->total_potongan = $total_potongan;
            $surat_pembelian_item->harga_buyback = $harga_terima;
            $surat_pembelian_item->save();
        }
        return array($surat_pembelian, $surat_pembelian_item);
    }

    static function create_sp_for_manual_buyback($params) {
        $post = $params['post'];
        $item = $params['item'];

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
        $berat_buyback = null;
        $total_potongan = null;
        $harga_terima = null;
        $berat_susut = 'tidak';
        $total_buyback = null;

        $berat_buyback = (float)$post['berat_terima'];
        $total_potongan = (float)$post['total_potongan'];
        $harga_terima = (float)$post['harga_terima'];
        if ($berat_buyback < $item->berat) {
            $berat_susut = 'ya';
        }
        $total_buyback = $harga_terima;

        $keterangan = null;
        if (isset($post['keterangan_transaksi'])) {
            $keterangan = $post['keterangan_transaksi'];
        }

        $surat_pembelian = SuratPembelian::create([
            'tanggal_surat' => $params['tanggal_surat'],
            'nomor_surat' => uniqid(),
            'time_key' => $params['time_key'],
            'user_id' => $params['user_id'],
            'username' => $params['username'],
            'pelanggan_id' => $pelanggan_id,
            'pelanggan_nama' => $pelanggan_nama,
            'pelanggan_username' => $pelanggan_username,
            'pelanggan_nik' => $pelanggan_nik,
            'keterangan' => $keterangan,
            'harga_total' => $harga_total,
            'total_bayar' => $total_bayar,
            'sisa_bayar' => $sisa_bayar,
            'total_buyback' => $total_buyback,
            'status_bayar' => $status_bayar,
            'status_buyback' => 'all',
            'tanggal_buyback' => $params['tanggal_surat'],
            'photo_path' => $photo_path,
        ]);

        // GENERATE NOMOR_SURAT
        $jumlah_item = 1;
        $simple_time_key = Accounting::simple_time_key($params['time_key']);
        $params_generate_nomor_surat = [
            'user_id' => $params['user_id'],
            'surat_pembelian_id' => $surat_pembelian->id,
            'pelanggan_id' => $pelanggan_id,
            'jumlah_item' => $jumlah_item,
            'simple_time_key' => $simple_time_key,
        ];
        $nomor_surat = self::generate_nomor_surat($params_generate_nomor_surat);

        // UPDATE surat_pembelian->nomor_surat
        $surat_pembelian->nomor_surat = $nomor_surat;
        $surat_pembelian->save();

        return $surat_pembelian;
    }

    static function update_status_buyback($surat_pembelian) {
        $surat_pembelian_items = $surat_pembelian->items;
        $spi_jumlah_bb = 0;
        foreach ($surat_pembelian_items as $spi) {
            if ($spi->status_buyback) {
                $spi_jumlah_bb++;
            }
        }
        
        $status_buyback = null;
        if ($spi_jumlah_bb === 0) {
            
        } elseif ($spi_jumlah_bb === count($surat_pembelian_items)) {
            $status_buyback = 'all';
        } elseif ($spi_jumlah_bb < count($surat_pembelian_items)) {
            $status_buyback = 'sebagian';
        }
        $surat_pembelian->status_buyback = $status_buyback;
        $surat_pembelian->save();
    }
}
