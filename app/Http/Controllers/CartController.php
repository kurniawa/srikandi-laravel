<?php

namespace App\Http\Controllers;

use App\Models\Cap;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Cashflow;
use App\Models\Item;
use App\Models\JenisPerhiasan;
use App\Models\Mainan;
use App\Models\Mata;
use App\Models\Menu;
use App\Models\SuratPembelian;
use App\Models\SuratPembelianItem;
use App\Models\TipePerhiasan;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    function index(User $user) {
        $cart = Cart::where('user_id', $user->id)->first();


        $data = [
            // 'goback' => 'home',
            // 'user_role' => $user_role,
            'menus' => Menu::get(),
            'route_now' => 'home',
            'profile_menus' => Menu::get_profile_menus(Auth::user()),
            'parent_route' => 'home',
            'spk_menus' => Menu::get_spk_menus(),
            // 'user' => Auth::user(),
            'cart' => $cart,
            'back' => true,
            'backRoute' => 'home',
            'backRouteParams' => null,
        ];
        // dd($data);
        return view('carts.index', $data);
    }

    function pilih_tipe_barang($from) {
        // dd($from);
        $cart = Cart::where('user_id', Auth::user()->id)->first();

        $data = [
            // 'goback' => 'home',
            // 'user_role' => $user_role,
            'menus' => Menu::get(),
            'route_now' => 'home',
            'profile_menus' => Menu::get_profile_menus(Auth::user()),
            'parent_route' => 'home',
            'spk_menus' => Menu::get_spk_menus(),
            // 'user' => Auth::user(),
            'from' => $from,
            'back' => true,
            'backRoute' => 'carts.index',
            'backRouteParams' => [Auth::user()->id],
            'cart' => $cart,
        ];

        return view('carts.pilih_tipe_barang', $data);
    }

    function create_item($from, $tipe_barang) {
        // dump($from);
        // dd($tipe_barang);
        $time = time();
        // dump($time);
        // dump(date("Y-m-d", $time));
        // dd(date("Y-m-d", $time - 86400));
        $tipe_perhiasans = TipePerhiasan::all();
        $jenis_perhiasans = JenisPerhiasan::select('id', 'nama as label', 'nama as value', 'tipe_perhiasan_id', 'tipe_perhiasan')->get();
        $caps = Cap::select('id', 'nama as label', 'nama as value', 'codename')->get();
        $warna_matas = Mata::select('warna as label', 'warna as value')->groupBy('warna')->get();
        $mainans = Mainan::select('id', 'nama as label', 'nama as value')->get();
        // dd($tipe_perhiasans);
        // dd($jenis_perhiasans);

        $cart = Cart::where('user_id', Auth::user()->id)->first();

        $data = [
            // 'goback' => 'home',
            // 'user_role' => $user_role,
            'menus' => Menu::get(),
            'route_now' => 'home',
            'profile_menus' => Menu::get_profile_menus(Auth::user()),
            'parent_route' => 'home',
            'back' => true,
            'backRoute' => 'carts.pilih_tipe_barang',
            'backRouteParams' => [$from],
            'spk_menus' => Menu::get_spk_menus(),
            // 'user' => Auth::user(),
            'from' => $from,
            'tipe_barang' => $tipe_barang,
            'tipe_perhiasans' => $tipe_perhiasans,
            'jenis_perhiasans' => $jenis_perhiasans,
            'caps' => $caps,
            'warna_matas' => $warna_matas,
            'mainans' => $mainans,
            'cart' => $cart,
        ];

        // dd($caps);

        return view('carts.create_item', $data);
    }

    function checkout(Cart $cart, Request $request) {
        $get = $request->query();

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

        $wallets_non_tunai = Wallet::where('kategori', 'non-tunai')->get();

        $data = [
            // 'goback' => 'home',
            // 'user_role' => $user_role,
            'menus' => Menu::get(),
            'route_now' => 'home',
            'profile_menus' => Menu::get_profile_menus(Auth::user()),
            'parent_route' => 'home',
            'back' => true,
            'backRoute' => 'carts.index',
            'backRouteParams' => [$cart->id],
            'spk_menus' => Menu::get_spk_menus(),
            // 'user' => Auth::user(),
            // 'from' => $from,
            'cart' => $cart,
            'cart_items' => $cart_items,
            'harga_total' => $harga_total,
            'users' => $users,
            'wallets_non_tunai' => $wallets_non_tunai,
        ];

        // dd($caps);

        return view('carts.checkout', $data);
    }

    function proses_checkout(Cart $cart, Request $request) {
        $post = $request->post();
        $user = Auth::user();
        // dump($cart);
        // dd($post);


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
        ]);
        // END - VALIDASI

        $harga_total = (string)($post['harga_total'] * 100) + 0;
        $total_bayar = (string)($post['total_bayar'] * 100) + 0;
        $sisa_bayar = (string)($post['sisa_bayar'] * 100) + 0;
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
        $pelanggan_nama = 'guest';
        $pelanggan = null;
        $pelanggan_id = null;
        if ($post['pelanggan_nama'] !== 'guest') {
            $pelanggan = User::where('username', $post['username_pelanggan'])->first();
            if (!$pelanggan) {
                $request->validate(['error'=>'required'],['error.required'=>'-pelanggan tidak ditemukan-']);
            }
            if ($user->id == $pelanggan->id) {
                $request->validate(['error'=>'required'],['error.required'=>'-admin dan pelanggan tidak boleh sama-']);
            }
            $pelanggan_nama = $pelanggan->nama;
            $pelanggan_id = $pelanggan->id;
        }
        // dd($cart);
        // dump((int)$post['sisa_bayar']);
        // dump($post);
        // dd($status_bayar);

        $time_key = time();
        $pembelian_new = SuratPembelian::create([
            'tanggal_surat' => date('Y-m-d', strtotime("$post[hari]-$post[bulan]-$post[tahun]")) . 'T' . date('H:i:s', $time_key),
            'no_surat' => uniqid(),
            'time_key' => $time_key,
            'user_id' => Auth::user()->id,
            'username' => Auth::user()->username,
            'pelanggan_id' => $cart->pelanggan_id,
            'pelanggan_nama' => $pelanggan_nama,
            'keterangan' => $cart->keterangan,
            'harga_total' => (string)$harga_total,
            'total_bayar' => (string)$total_bayar,
            'sisa_bayar' => (string)$sisa_bayar,
            'status_bayar' => $status_bayar,
        ]);
        $success_ .= 'Pembelian baru dibuat!';

        $no_surat = SuratPembelian::generate_no_surat($pembelian_new->id, $pelanggan_id, count($post['cart_item_ids']), $time_key);
        $pembelian_new->no_surat = $no_surat;
        $pembelian_new->save();
        $success_ .= '-no_surat, status_bb Pembelian diupdate!-';

        $jumlah_item_perhiasan = 0;
        $pembelian_items = collect();

        // CREATE SURAT_PEMBELIAN_ITEM DAN CASHFLOW
        foreach ($post['cart_item_ids'] as $cart_item_id) {
            SuratPembelianItem::create_surat_pembelian_item_and_cashflow($post, $pembelian_new, $cart_item_id, $time_key);
        }
        $success_ .= '-Items diinput! Stok diupdate!-';

        // END - CREATE SURAT_PEMBELIAN_ITEM DAN CASHFLOW

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


        // UPDATE no_surat dan time_key dan status_bb
        // $status_bb_pembelian = null;
        // if ($jumlah_item_perhiasan > 0) {
        //     $status_bb_pembelian = 'ada';
        // }
        // list($no_surat) = SuratPembelian::generate_no_surat($pembelian_new->id, $pelanggan_id, count($post['item_id']), $time_key);
        // $no_surat = SuratPembelian::generate_no_surat($pembelian_new->id, $pelanggan_id, count($post['item_id']), $time_key);
        // $pembelian_new->no_surat = $no_surat;
        // // $pembelian_new->time_key = $time_key;
        // // $pembelian_new->status_bb = $status_bb_pembelian;
        // $pembelian_new->save();
        // $success_ .= '-no_surat, status_bb Pembelian diupdate!-';

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
        if (count($cart->cart_items) === 0) {
            $cart->delete();
            $success_ .= '-Cart dihapus!-';
        }

        $feedback = [
            'success_' => $success_,
            'errors_' => $errors_,
            'warnings_' => $warnings_,
        ];

        return redirect(route('surat_pembelian.index'))->with($feedback);
    }
}
