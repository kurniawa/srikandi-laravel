<?php

namespace App\Http\Controllers;

use App\Models\Accounting;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Cashflow;
use App\Models\Item;
use App\Models\Menu;
use App\Models\SuratPembelian;
use App\Models\SuratPembelianItem;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CartController extends Controller
{
    function index(User $user)
    {
        $cart = Cart::where('user_id', $user->id)->first();

        $data = [
            // 'goback' => 'home',
            // 'user_role' => $user_role,
            'menus' => Menu::get(),
            // 'route_now' => 'home',
            'profile_menus' => Menu::get_profile_menus(Auth::user()),
            // 'parent_route' => 'home',
            // 'spk_menus' => Menu::get_spk_menus(),
            // 'user' => Auth::user(),
            'cart' => $cart,
            'user' => $user,
            'back' => true,
            'backRoute' => 'home',
            'backRouteParams' => null,
            'all_items_x_photos' => Item::get_all_item_x_photos(null, null),
        ];
        // dd($data);
        return view('carts.index', $data);
    }



    function checkout(Cart $cart, Request $request)
    {
        // dump(casual_decimal_format(60000020));
        // dump(casual_decimal_format(60000021));
        // dd(casual_decimal_format(60000000));
        $get = $request->query();
        $user = Auth::user();

        // dump($cart);
        // dd($get);

        $cart_items = collect();
        $harga_total = 0;
        foreach ($get['cart_item_id'] as $cart_item_id) {
            $cart_item = CartItem::find($cart_item_id);
            $cart_items->push($cart_item);
            $harga_total += (float)$cart_item->harga_t;
        }
        // dd($cart_items);

        $users = User::all();

        $wallets_non_tunai = Wallet::where('kategori_wallet', 'non-tunai')->get();

        $pelangganid = null;
        $pelanggannama = null;
        $pelangganusername = null;
        $pelanggannik = null;
        if ($cart->pelanggan_id) {
            $pelangganid = $cart->pelanggan_id;
            $pelanggannama = $cart->pelanggan->nama;
            $pelangganusername = $cart->pelanggan->username;
            $pelanggannik = $cart->pelanggan->nik;
        }

        $user_lists = User::where('clearance_level', '>=', 3)->get();
        $data = [
            // 'goback' => 'home',
            // 'user_role' => $user_role,
            'menus' => Menu::get(),
            'route_now' => 'home',
            'profile_menus' => Menu::get_profile_menus(Auth::user()),
            'parent_route' => 'home',
            'back' => true,
            'backRoute' => 'carts.index',
            'backRouteParams' => [$user->id],
            // 'spk_menus' => Menu::get_spk_menus(),
            // 'user' => Auth::user(),
            // 'from' => $from,
            'cart' => $cart,
            'user' => $user,
            'cart_items' => $cart_items,
            'harga_total' => $harga_total,
            'users' => $users, // Semua user, dipakai nanti untuk cari dan menentukan data customer pada saat checkout
            'user_lists' => $user_lists, // Semua user admin, dipakai untuk proses_checkout, apabila admin pemegang HP belum tentu admin yang melayani checkout
            'wallets_non_tunai' => $wallets_non_tunai,
            'pelangganid' => $pelangganid,
            'pelanggannama' => $pelanggannama,
            'pelangganusername' => $pelangganusername,
            'pelanggannik' => $pelanggannik,
            'all_items_x_photos' => Item::get_all_item_x_photos(null, null),
        ];

        // dd($pelangganid);

        return view('carts.checkout', $data);
    }

    function proses_checkout(Cart $cart, Request $request)
    {
        $post = $request->post();
        // dump($post);
        $user = Auth::user();
        // $res_admin_validation = User::admin_validation($user->id, $post['target_user_id'], $post['target_password']);
        // dump($res_admin_validation);
        // dd($res_admin_validation->getStatusCode());
        // VALIDASI ADMIN
        if ($user->id != $post['target_user_id']) {
            $user = User::admin_validation($user->id, $post['target_user_id'], $post['target_password']);
            if (!$user) {
                $request->validate(['error'=>'required'],['error.required'=>'-terjadi kesalahan data admin/password-']);
            }
        }
        // END - VALIDASI ADMIN

        Cashflow::validasi_metode_pembayaran($request);
        // dump($cart);
        // dd($post);

        // PENGECEKAN File Storage Photo

        // foreach ($post['cart_item_ids'] as $cart_item_id) {
        //     $cart_item = CartItem::find($cart_item_id);
        //     if ($cart_item->photo_path) {
        //         dump($cart_item->photo_path);
        //         dump(Storage::exists($cart_item->photo_path));
        //     } else {
        //         if (count($cart_item->item->item_photos)) {
        //             dump($cart_item->item->item_photos[0]->photo);
        //             dump(Storage::exists($cart_item->item->item_photos[0]->photo));
        //         }
        //     }
        // }
        // dd('stop');

        // END - PENGECEKAN File Storage Photo

        $success_ = '';
        $warnings_ = '';
        $errors_ = '';
        $post = $request->post();

        // VALIDASI
        $request->validate([
            'hari' => 'required|numeric',
            'bulan' => 'required|numeric',
            'tahun' => 'required|numeric',
            'harga_total' => 'required|numeric',
            'total_bayar' => 'required|numeric',
            'sisa_bayar' => 'required|numeric',
            'tipe_transaksi' => 'required',
        ]);
        // END - VALIDASI

        $harga_total = (float)$post['harga_total'];
        $total_bayar = (float)$post['total_bayar'];
        $sisa_bayar = (float)$post['sisa_bayar'];
        // dump(time());
        // dd($sisa_bayar);

        // dd($post);
        // dump(date('d-m-Y',strtotime("$post[hari]-$post[bulan]-$post[tahun]")));
        // dump(date('Y-m-d',strtotime("$post[hari]-$post[bulan]-$post[tahun]")));
        // dump(date('Y-m-d',strtotime("$post[tahun]-$post[bulan]-$post[hari]")));
        // dump(date('d-m-Y'));
        // dump(date('d-m-Y') == date('d-m-Y',strtotime("$post[hari]-$post[bulan]-$post[tahun]")));
        // dump(date('d-m-Y') === date('d-m-Y',strtotime("$post[hari]-$post[bulan]-$post[tahun]")));
        // dd($post);
        // dump($request->file());
        // dump((int)$post['total_bayar']);

        // dd($cart_items);

        // VALIDASI PHOTO
        // foreach ($cart_items as $key => $cart_item) {
        //     $item = Item::find($cart_item->item_id);
        //     // $files = $request->file();
        //     // $ada_foto = false;
        //     // if (isset($files["item-photo-$key"])) {
        //     //     $ada_foto = true;
        //     // }
        //     // if (!$ada_foto) {
        //     //     if (count($item->photos) === 0) {
        //     //         $request->validate(['error'=>'required'],['error.required'=>'Pembelian gagal! Terdapat foto barang yang tidak diupload!']);
        //     //     }
        //     // }
        //     if ($item->tipe_barang === 'perhiasan' || $item->tipe_barang === 'LM') {
        //         if (count($item->photo_utama) === 0) {
        //             $request->validate(['error'=>'required'],['error.required'=>'Pembelian gagal! Terdapat foto barang yang tidak diupload!']);
        //         }
        //     }
        // }
        // // END - VALIDASI PHOTO

        // STATUS BAYAR
        $status_bayar = 'lunas';
        if ((float)$post['sisa_bayar'] > 0.0) {
            $status_bayar = 'belum-lunas';
        }
        // END - STATUS BAYAR
        // if ($cart->pelanggan_id == Auth::user()->id) {
        //     $request->validate(['error'=>'required'],['error.required'=>'User tidak boleh membeli untuk diri sendiri!']);
        // }
        $pelanggan = null;
        $error_cari_data_pelanggan = false;
        $feedback_cek_pelanggan = "";

        // dd($post);
        list($pelanggan, $error_cari_data_pelanggan, $feedback_cek_pelanggan) = User::cari_data_pelanggan($post['pelanggan_nama'], $post['pelanggan_username'], $post['pelanggan_nik']);

        if ($error_cari_data_pelanggan) {
            $request->validate(['error' => 'required'], ['error.required' => $feedback_cek_pelanggan]);
        }

        $pelanggan_id = null;
        $pelanggan_nama = null;
        $pelanggan_username = null;
        $pelanggan_nik = null;
        if ($pelanggan) {
            $pelanggan_id = $pelanggan->id;
            $pelanggan_nama = $pelanggan->nama;
            $pelanggan_username = $pelanggan->username;
            $pelanggan_nik = $pelanggan->nik;
            SuratPembelian::customer_cannot_be_user($user->id, $pelanggan_id, $request);
        }
        // dd($cart);
        // dump((int)$post['sisa_bayar']);
        // dump($post);
        // dd($status_bayar);

        $time_key = time();
        $simple_time_key = Accounting::simple_time_key($time_key);

        $photo_path = null;
        if ($cart->photo_path) {
            if (Storage::exists($cart->photo_path)) {
                $exploded_filenamepath = explode("/", $cart->photo_path);
                $name_index = count($exploded_filenamepath) - 1;
                $filename = $exploded_filenamepath[$name_index];
                $photo_path = "surat_pembelians/photos/$filename";
                Storage::move($cart->photo_path, $photo_path);
            }
        }
        $pembelian_new = SuratPembelian::create([
            'tanggal_surat' => date('Y-m-d', strtotime("$post[hari]-$post[bulan]-$post[tahun]")) . 'T' . date('H:i:s', $time_key),
            'nomor_surat' => uniqid(),
            'time_key' => $time_key,
            'user_id' => $user->id,
            'username' => $user->username,
            'pelanggan_id' => $pelanggan_id,
            'pelanggan_nama' => $pelanggan_nama,
            'pelanggan_username' => $pelanggan_username,
            'pelanggan_nik' => $pelanggan_nik,
            'keterangan' => $cart->keterangan,
            'harga_total' => (string)($harga_total * 100),
            'total_bayar' => (string)($total_bayar * 100),
            'sisa_bayar' => (string)($sisa_bayar * 100),
            'status_bayar' => $status_bayar,
            'photo_path' => $photo_path,
        ]);

        $success_ .= 'Pembelian baru dibuat!';

        $nomor_surat = SuratPembelian::generate_nomor_surat($user, $pembelian_new->id, $pelanggan_id, count($post['cart_item_ids']), $simple_time_key);
        $pembelian_new->nomor_surat = $nomor_surat;
        $pembelian_new->save();
        $success_ .= '-nomor_surat, status_bb Pembelian diupdate!-';

        // CREATE SURAT_PEMBELIAN_ITEM
        // Create kode_accounting
        $kode_accounting = "$user->id.$time_key";

        foreach ($post['cart_item_ids'] as $cart_item_id) {
            SuratPembelianItem::create_surat_pembelian_item($user, $pembelian_new, $cart_item_id, $kode_accounting);
        }
        $success_ .= '-Items diinput! Stok diupdate!-';

        // END - CREATE SURAT_PEMBELIAN_ITEM

        // // CASHFLOW
        
        // dump($post);
        // $jumlah = ((float)$jumlah_tunai + (float)$sisa_bayar) * 100;
        // dump($jumlah_tunai);
        // dump((float)$jumlah_tunai);
        // dump($sisa_bayar);
        // dump((float)$sisa_bayar);
        // dd($jumlah);
        $total_bayar_2 = Cashflow::create_cashflow($user->id, $time_key, $kode_accounting, $pembelian_new->id, $post);
        // $jumlah = 0;
        // $jumlah_terima_total = 0;
        // if (isset($post['jumlah_tunai'])) {
        //     if ($post['jumlah_tunai'] !== null) {
        //         if ((int)$post['sisa_bayar'] < 0) {
        //             $jumlah = ((float)$post['jumlah_tunai'] * 100) + ((float)$post['sisa_bayar'] * 100);
        //         } else {
        //             $jumlah = (float)$post['jumlah_tunai'] * 100;
        //         }
        //         $wallet = Wallet::where('tipe_wallet', 'laci')->where('nama', 'cash')->first();
        //         $cashflow = Cashflow::create([
        //             'user_id' => Auth::user()->id,
        //             'time_key' => $time_key,
        //             'kode_accounting' => $kode_accounting,
        //             'surat_pembelian_id' => $pembelian_new->id,
        //             // 'surat_pembelian_item_id' => $surat_pembelian_item->id,
        //             // 'nama_transaksi' => $nama_transaksi,
        //             'tipe' => 'pemasukan',
        //             'kategori_wallet' => $wallet->kategori_wallet,
        //             'tipe_wallet' => $wallet->tipe_wallet,
        //             'nama_wallet' => $wallet->nama_wallet,
        //             'jumlah' => $jumlah,
        //         ]);
        //         // self::create_update_neraca($tipe_wallet, $nama_wallet, $jumlah);

        //         // CEK Saldo terkait

        //         Saldo::cek_saldo_wallet_sebelumnya_dan_create_apabila_belum_ada($time_key, $wallet, $jumlah);
        //     }
        //     $jumlah_terima_total += $jumlah;
        // }

        // if (isset($post['jumlah_non_tunai'])) { // kodingan pada blade sempat di edit, js dipake bareng2, awalnya ini namanya jumlah_non_tunai
        //     foreach ($post['jumlah_non_tunai'] as $key => $jumlah_non_tunai) {
        //         if ($jumlah_non_tunai !== null) {
        //             $wallet = Wallet::where('tipe_wallet', $post['tipe_instansi'][$key])->where('nama_wallet', $post['nama_instansi'][$key])->first();
        //             // $tipe_wallet = $post['tipe_instansi'][$key];
        //             // $nama_wallet = $post['nama_instansi'][$key];
        //             $jumlah = $jumlah_non_tunai * 100;
        //             $cashflow = Cashflow::create([
        //                 'user_id' => Auth::user()->id,
        //                 'time_key' => $time_key,
        //                 'kode_accounting' => $kode_accounting,
        //                 'surat_pembelian_id' => $pembelian_new->id,
        //                 // 'nama_transaksi' => $nama_transaksi,
        //                 'tipe' => 'pemasukan',
        //                 'kategori_wallet' => $wallet->kategori_wallet,
        //                 'tipe_wallet' => $wallet->tipe_wallet,
        //                 'nama_wallet' => $wallet->nama_wallet,
        //                 'jumlah' => $jumlah,
        //             ]);
        //             // self::create_update_neraca($tipe_wallet, $nama_wallet, $jumlah);
        //             Saldo::cek_saldo_wallet_sebelumnya_dan_create_apabila_belum_ada($time_key, $wallet, $jumlah);
        //             $jumlah_terima_total += $jumlah;
        //         }
        //     }
        // }
        // // END - CASHFLOW


        // // ITEM PHOTO APAKAH DARI YANG BARUSAN DI UPLOAD ATAU DARI FOTO ITEM YANG SUDAH ADA DI DB ATAU TIDAK ADA PHOTO?
        // $files = $request->file();
        // $item_photo = null;
        // // $photo = null;
        // if (isset($files["item-photo-$key"])) {
        //     $photo_name = "IP-". uniqid() . "." . $files["item-photo-$key"]->getClientOriginalExtension();
        //     // $path = Storage::putFileAs(
        //     //     'public/images/item_photos', $file, $photo_name
        //     // );
        //     $path = 'images/pembelian/' . $photo_name;
        //     if (! Storage::putFileAs('images/pembelian/', $files["item-photo-$key"], $photo_name)) {
        //         $errors_ .= ' Photo gagal diupload!';
        //     } else {
        //         $success_ .= ' Photo storaged!';
        //         // $photo = Photo::create([
        //         //     'path' => $path,
        //         // ]);
        //         $item_photo = $path;

        //     }
        // }

        // if ($item_photo === null) { // kalau tidak upload photo pembelian, maka cari foto utama
        //     if (count($item->photos) === 0) {
        //         $pembelian_new->delete();
        //         $request->validate(['error'=>'required'],['error.required'=>'Pembelian gagal! Terdapat foto barang yang tidak diupload!']);
        //     } else {

        //         $item_photo_utama = ItemPhoto::where('item_id', $item->id)->where('tipe', 'utama')->first();
        //         $item_photo = $item_photo_utama->path;
        //     }
        // }
        // END - PHOTO


        // UPDATE nomor_surat dan time_key dan status_bb
        // $status_bb_pembelian = null;
        // if ($jumlah_item_perhiasan > 0) {
        //     $status_bb_pembelian = 'ada';
        // }
        // list($nomor_surat) = SuratPembelian::generate_nomor_surat($pembelian_new->id, $pelanggan_id, count($post['item_id']), $time_key);
        // $nomor_surat = SuratPembelian::generate_nomor_surat($pembelian_new->id, $pelanggan_id, count($post['item_id']), $time_key);
        // $pembelian_new->nomor_surat = $nomor_surat;
        // // $pembelian_new->time_key = $time_key;
        // // $pembelian_new->status_bb = $status_bb_pembelian;
        // $pembelian_new->save();
        // $success_ .= '-nomor_surat, status_bb Pembelian diupdate!-';

        // CASHFLOW
        /**
         * Untuk keperluan trial/masa percobaan, maka ketika input pembelian yang sudah berlalu, maka tidak akan masuk ke cashflow
         */
        // generate nama_transaksi
        // if (date('Y-m-d', strtotime("$post[hari]-$post[bulan]-$post[tahun]")) >= date('Y-m-d')) {
        //     $nama_transaksi = SuratPembelian::get_nama_transaksi($pembelian_new->id);

        //     if (Cashflow::create_cashflow_pembelian($post, $pembelian_new->id, $nama_transaksi, $time_key)) {
        //         $success_ .= ' Cashflow diupdate!';
        //     } else {
        //         $errors_ .= 'ERR: entry cashflow';
        //     }

        //     // CEK / UPDATE CASHFLOW
        //     // cek apakah cashflow->jumlah keseluruhan sudah sama dengan $pembelian->harga_total, atau malah kelebihan bayar jadi ada sisa_bayar(kembalian)
        //     list($success2_, $warnings2_) = SuratPembelian::cek_update_cashflow_setelah_pembelian($pembelian_new->id);
        //     $success_ .= $success2_;
        //     $warnings_ .= $warnings2_;
        // } else {
        //     $warnings_ .= 'pembelian lampau.';
        // }
        // END: UPDATE cashflows

        // HAPUS CART
        $success_ .= Cart::delete_cart_items($post['cart_item_ids'], $cart, false);

        $feedback = [
            'success_' => $success_,
            'errors_' => $errors_,
            'warnings_' => $warnings_,
        ];

        return redirect(route('surat_pembelian.index'))->with($feedback);
    }

    function insert_to_cart(Item $item, User $user, Request $request)
    {
        $success_ = '';
        $post = $request->post();
        if (isset($post['submit']) && $post['submit'] == 'update_harga') {
            // dump($item);
            // dd($post);
            $item->harga_g = $post['harga_g'];
            $item->ongkos_g = $post['ongkos_g'];
            $item->harga_t = $post['harga_t'];
            $item->save();
            $success_ .= "-Item diupdate-";
            // Terdapat kasus dimana item ini sebelumnya sudah ada di keranjang.
            // Oleh karena itu setelah update harga_t, maka perlu untuk update harga_t pada cart
            // UPDATE harga_t pada cart
            $cart = Cart::where('user_id', $user->id)->first();
            $cart_items = CartItem::where('cart_id', $cart->id)->where('item_id', $item->id)->get();
            if (count($cart_items)) {
                foreach ($cart_items as $cart_item) {
                    $cart_item->harga_t = $item->harga_t;
                    $cart_item->save();
                }
                // UPDATE harga_total pada carts
                $cart_items_2 = CartItem::where('cart_id', $cart->id)->get();
                $harga_total = 0;
                foreach ($cart_items_2 as $cart_item) {
                    $harga_total += $cart_item->harga_t;
                }
                $cart->harga_total = (string)$harga_total;
                $cart->save();
                $success_ .= "-Data cart diupdate-";
                // END - UPDATE harga_total pada carts
            }
            // END - UPDATE harga_t pada cart
        }
        // dd($post);
        Cart::insert_to_cart_helper($item, $user);
        $success_ .= "-Item telah diinput ke keranjang-";
        $feedback = [
            'success_' => $success_
        ];
        return back()->with($feedback);
    }
}
