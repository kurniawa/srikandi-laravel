<?php

namespace App\Http\Controllers;

use App\Models\Accounting;
use App\Models\Cart;
use App\Models\Cashflow;
use App\Models\Item;
use App\Models\Menu;
use App\Models\Photo;
use App\Models\Saldo;
use App\Models\SuratPembelian;
use App\Models\SuratPembelianItem;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SuratPembelianController extends Controller
{
    function index(Request $request)
    {
        $user = Auth::user();
        $cart = null;
        if ($user) {
            $cart = Cart::where('user_id', $user->id)->first();
        }

        $get = $request->query();
        if ($get) {
            // dd($get);
            if ($get['pelanggan_nama'] && $get['username'] && $get['from_day'] && $get['from_month'] && $get['from_year'] && $get['to_day'] && $get['to_month'] && $get['to_year']) {
                $from = "$get[from_year]-$get[from_month]-$get[from_day]";
                $until = "$get[to_year]-$get[to_month]-$get[to_day] 23:59:59";
                $surat_pembelians = SuratPembelian::where('pelanggan_nama', 'like', "%$get[pelanggan_nama]%")->where('username', $get['username'])->whereBetween('created_at', [$from, $until])->orderByDesc('created_at')->orderByDesc('created_at')->get();
            } elseif ($get['pelanggan_nama'] && !$get['username'] && $get['from_month'] && $get['from_year'] && $get['to_day'] && $get['to_month'] && $get['to_year']) {
                $from = "$get[from_year]-$get[from_month]-$get[from_day]";
                $until = "$get[to_year]-$get[to_month]-$get[to_day] 23:59:59";
                $surat_pembelians = SuratPembelian::where('pelanggan_nama', 'like', "%$get[pelanggan_nama]%")->whereBetween('created_at', [$from, $until])->orderByDesc('created_at')->get();
            } elseif (!$get['pelanggan_nama'] && $get['username'] && $get['from_month'] && $get['from_year'] && $get['to_day'] && $get['to_month'] && $get['to_year']) {
                $from = "$get[from_year]-$get[from_month]-$get[from_day]";
                $until = "$get[to_year]-$get[to_month]-$get[to_day] 23:59:59";
                $surat_pembelians = SuratPembelian::where('username', $get['username'])->whereBetween('created_at', [$from, $until])->orderByDesc('created_at')->get();
            } elseif (!$get['pelanggan_nama'] && !$get['username'] && $get['from_month'] && $get['from_year'] && $get['to_day'] && $get['to_month'] && $get['to_year']) {
                $from = "$get[from_year]-$get[from_month]-$get[from_day]";
                $until = "$get[to_year]-$get[to_month]-$get[to_day] 23:59:59";
                $surat_pembelians = SuratPembelian::whereBetween('created_at', [$from, $until])->orderByDesc('created_at')->get();
            } elseif ($get['pelanggan_nama'] && $get['username']) {
                $surat_pembelians = SuratPembelian::where('pelanggan_nama', 'like', "%$get[pelanggan_nama]%")->where('username', $get['username'])->orderByDesc('created_at')->get();
            } elseif ($get['pelanggan_nama'] && !$get['username']) {
                $surat_pembelians = SuratPembelian::where('pelanggan_nama', 'like', "%$get[pelanggan_nama]%")->orderByDesc('created_at')->get();
            } elseif (!$get['pelanggan_nama'] && $get['username']) {
                $surat_pembelians = SuratPembelian::where('username', $get['username'])->orderByDesc('created_at')->get();
            } else {
                dump($get);
                dd('ada kesalahan pada filter');
            }
        } else {
            $surat_pembelians = SuratPembelian::orderByDesc('created_at')->limit(200)->get();
        }
        // my_decimal_format(100000);
        // my_decimal_format(100002);
        // my_decimal_format(100023);
        // dd('');
        // dd($surat_pembelians[0]->items);
        $data = [
            // 'goback' => 'home',
            // 'user_role' => $user_role,
            'menus' => Menu::get(),
            'profile_menus' => Menu::get_profile_menus(Auth::user()),
            // 'route_now' => 'home',
            // 'parent_route' => 'home',
            // 'backRoute' => 'home',
            // 'backRouteParams' => null,
            // 'spk_menus' => Menu::get_spk_menus(),
            // 'user' => Auth::user(),
            'cart' => $cart,
            'user' => $user,
            'back' => true,
            'surat_pembelians' => $surat_pembelians,
            'all_items_x_photos' => Item::get_all_item_x_photos(null, null),
        ];
        // dd($data);
        return view('surats.index', $data);
    }

    function show(SuratPembelian $surat_pembelian)
    {
        // dd($surat_pembelian);

        $user = Auth::user();
        $cart = null;
        if ($user) {
            $cart = Cart::where('user_id', $user->id)->first();
        }

        $pelanggan_nama = "guest";
        $pelanggan_username = "guest";
        $pelangganid = null;
        $pelanggannama = null;
        $pelangganusername = null;
        $pelanggannik = null;
        if ($surat_pembelian->pelanggan_id !== null) {
            $pelanggan_nama = $surat_pembelian->pelanggan_nama;
            $pelanggan_username = $surat_pembelian->pelanggan_username;
            $pelangganid = $surat_pembelian->pelanggan_id;
            $pelanggannama = $surat_pembelian->pelanggan_nama;
            $pelangganusername = $surat_pembelian->pelanggan_username;
            $pelanggannik = $surat_pembelian->pelanggan_nik;
        }

        $wallets_non_tunai = Wallet::where('kategori', 'non-tunai')->get();

        $users = User::all();
        // dd($surat_pembelian->cashflows);

        $data = [
            // 'goback' => 'home',
            // 'user_role' => $user_role,
            'menus' => Menu::get(),
            'route_now' => 'home',
            'profile_menus' => Menu::get_profile_menus(Auth::user()),
            'parent_route' => 'home',
            // 'spk_menus' => Menu::get_spk_menus(),
            // 'user' => Auth::user(),
            'cart' => $cart,
            'user' => $user,
            'back' => true,
            'backRoute' => 'home',
            'backRouteParams' => null,
            'surat_pembelian' => $surat_pembelian,
            'pelanggan_nama' => $pelanggan_nama,
            'pelanggan_username' => $pelanggan_username,
            'wallets_non_tunai' => $wallets_non_tunai,
            'users' => $users,
            'route_cari_data_pelanggan' => "surat_pembelian.update_data_pelanggan",
            'pelangganid' => $pelangganid,
            'pelanggannama' => $pelanggannama,
            'pelangganusername' => $pelangganusername,
            'pelanggannik' => $pelanggannik,
            'all_items_x_photos' => Item::get_all_item_x_photos(null, null),
        ];
        // dd($data);
        return view('surats.show', $data);
    }

    function update_data_pelanggan(SuratPembelian $surat_pembelian, Request $request)
    {
        $post = $request->post();
        // dump($post);
        // dd($surat_pembelian);
        // dump($user->id);
        // dd($surat_pembelian->pelanggan_id);
        $success_ = "";

        $pelanggan = null;
        $error_cari_data_pelanggan = false;
        $feedback_cek_pelanggan = "";

        list($pelanggan, $error_cari_data_pelanggan, $feedback_cek_pelanggan) = User::cari_data_pelanggan($post['pelanggan_nama'], $post['pelanggan_username'], $post['pelanggan_nik']);

        if ($error_cari_data_pelanggan) {
            $request->validate(['error' => 'required'], ['error.required' => $feedback_cek_pelanggan]);
        }

        $user = Auth::user();
        if ($pelanggan) {
            $surat_pembelian->pelanggan_id = $pelanggan->id;
            $surat_pembelian->pelanggan_nama = $pelanggan->nama;
            $surat_pembelian->pelanggan_username = $pelanggan->username;
            $surat_pembelian->pelanggan_nik = $pelanggan->nik;
            SuratPembelian::customer_cannot_be_user($user->id, $pelanggan->id, $request);
        } else {
            $surat_pembelian->pelanggan_id = null;
            $surat_pembelian->pelanggan_nama = null;
            $surat_pembelian->pelanggan_username = null;
            $surat_pembelian->pelanggan_nik = null;
        }
        $surat_pembelian->save();
        $success_ .= "-Data pelanggan telah diupdate-";

        $feedback = [
            "success_" => $success_
        ];

        return back()->with($feedback);
    }

    function print_out(SuratPembelian $surat_pembelian)
    {
        $user = Auth::user();
        $cart = null;
        if ($user) {
            $cart = Cart::where('user_id', $user->id)->first();
        }
        // $time = time();
        // dump($time);
        // $day = (int)date("d");
        // $month = (int)date("m");
        // $year = (int)date("Y");
        // $faktor_bagi = $day + $month + $year;
        // $nomor_surat = $time / $faktor_bagi;
        // dump($nomor_surat);
        // dump((int)$nomor_surat);
        // $hasil_kali = (int)$nomor_surat * $faktor_bagi;
        // $tanggal_kembali = date("d-m-Y H:i:s", $hasil_kali);
        // dd($tanggal_kembali);

        $pelanggan_nama = "guest";
        $pelanggan_username = "guest";
        $pelangganid = null;
        $pelanggannama = null;
        $pelangganusername = null;
        $pelanggannik = null;
        if ($surat_pembelian->pelanggan_id !== null) {
            $pelanggan_nama = $surat_pembelian->pelanggan_nama;
            $pelanggan_username = $surat_pembelian->pelanggan_username;
            $pelangganid = $surat_pembelian->pelanggan_id;
            $pelanggannama = $surat_pembelian->pelanggan_nama;
            $pelangganusername = $surat_pembelian->pelanggan_username;
            $pelanggannik = $surat_pembelian->pelanggan_nik;
        }

        $wallets_non_tunai = Wallet::where('kategori', 'non-tunai')->get();

        $data = [
            // 'goback' => 'home',
            // 'user_role' => $user_role,
            'menus' => Menu::get(),
            'route_now' => 'home',
            'profile_menus' => Menu::get_profile_menus(Auth::user()),
            'parent_route' => 'home',
            // 'spk_menus' => Menu::get_spk_menus(),
            // 'user' => Auth::user(),
            'cart' => $cart,
            'user' => $user,
            'back' => true,
            'backRoute' => 'home',
            'backRouteParams' => null,
            'surat_pembelian' => $surat_pembelian,
            'pelanggan_nama' => $pelanggan_nama,
            'pelanggan_username' => $pelanggan_username,
            'wallets_non_tunai' => $wallets_non_tunai,
            // 'users' => $users,
            'route_cari_data_pelanggan' => "surat_pembelian.update_data_pelanggan",
            'pelangganid' => $pelangganid,
            'pelanggannama' => $pelanggannama,
            'pelangganusername' => $pelangganusername,
            'pelanggannik' => $pelanggannik,
            'all_items_x_photos' => Item::get_all_item_x_photos(null, null),
        ];
        // dd($data);
        return view('surats.print-out', $data);
    }

    function delete(SuratPembelian $surat_pembelian)
    {
        // dd($surat_pembelian);
        $dangers_ = "";
        foreach ($surat_pembelian->items as $surat_pembelian_item) {
            if ($surat_pembelian_item->photo_path) {
                if (Storage::exists($surat_pembelian_item->photo_path)) {
                    Storage::delete($surat_pembelian_item->photo_path);
                    $dangers_ .= "-SPI-Photo $surat_pembelian->id dihapus-";
                }
            }
            $surat_pembelian_item->delete();
            $dangers_ .= "-SPI $surat_pembelian_item->id dihapus-";
        }

        foreach ($surat_pembelian->cashflows as $cashflow) {
            $cashflow_date = date("Y-m-d", strtotime($cashflow->created_at));
            $last_hour_of_date = date("Y-m-d H:i:s", strtotime("$cashflow_date 23:59:59"));

            $wallet = Wallet::where('kategori_wallet', $cashflow->kategori_wallet)->where('tipe_wallet', $cashflow->tipe_wallet)->where('nama_wallet', $cashflow->nama_wallet)->whereBetween("created_at", [$cashflow_date, $last_hour_of_date])->latest()->first();
            $jumlah_saldo = (int)$wallet->saldo;
            if ($cashflow->tipe == 'pengeluaran') {
                $wallet->saldo = (string)($jumlah_saldo + (int)$cashflow->jumlah);
                $wallet->save();
            } else if ($cashflow->tipe == 'pemasukan') {
                $wallet->saldo = (string)($jumlah_saldo - (int)$cashflow->jumlah);
                $wallet->save();
            }
            $dangers_ .= "-Saldo diupdate-";
        }

        if ($surat_pembelian->photo_path) {
            if ($surat_pembelian->photo_path) {
                if (Storage::exists($surat_pembelian->photo_path)) {
                    Storage::delete($surat_pembelian->photo_path);
                    $dangers_ .= "-SP-Photo $surat_pembelian->id dihapus-";
                }
            }
        }

        $surat_pembelian->delete();
        $dangers_ .= "-SP $surat_pembelian->id dihapus-";

        $feedback = [
            "dangers_" => $dangers_,
        ];

        return redirect()->route('surat_pembelian.index')->with($feedback);
    }

    function delete_photo(SuratPembelian $surat_pembelian)
    {
        $dangers_ = "";
        if ($surat_pembelian->photo_path) {
            if (Storage::exists($surat_pembelian->photo_path)) {
                Storage::delete($surat_pembelian->photo_path);
                $dangers_ .= "-File Foto dihapus-";
            }
        }

        $surat_pembelian->photo_path = null;
        $surat_pembelian->save();

        $feedback = [
            'dangers_' => $dangers_
        ];

        return back()->with($feedback);
    }

    function update_photo(SuratPembelian $surat_pembelian, Request $request)
    {
        $file_photo = $request->file('photo');
        // dump($post);
        // dump($photo);
        // dd($cart);

        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $success_ = "";

        list($file_name, $photo_path) = Photo::cek_photo_path('surat_pembelians/photos', $file_photo->extension());
        // dd($file_name, $photo_path);
        $file_photo->storeAs('surat_pembelians/photos', $file_name);

        $surat_pembelian->photo_path = $photo_path;
        $surat_pembelian->save();

        $success_ .= "-surat_pembelian->photo_path $surat_pembelian->photo_path created-";

        $feedback = [
            "success_" => $success_
        ];

        return back()->with($feedback);
    }

    function buyback(SuratPembelian $surat_pembelian)
    {
        // dd($surat_pembelian);
        $user = Auth::user();
        $cart = null;
        if ($user) {
            $cart = Cart::where('user_id', $user->id)->first();
        }
        $wallets_non_tunai = Wallet::where('kategori', 'non-tunai')->get();

        $data = [
            // 'goback' => 'home',
            // 'user_role' => $user_role,
            'menus' => Menu::get(),
            'route_now' => 'home',
            'profile_menus' => Menu::get_profile_menus(Auth::user()),
            'parent_route' => 'home',
            // 'spk_menus' => Menu::get_spk_menus(),
            // 'user' => Auth::user(),
            'cart' => $cart,
            'user' => $user,
            'surat_pembelian' => $surat_pembelian,
            'wallets_non_tunai' => $wallets_non_tunai,
            'all_items_x_photos' => Item::get_all_item_x_photos(null, null),
        ];
        // dd($data);
        return view('surats.buyback', $data);
    }

    function proses_buyback(SuratPembelian $surat_pembelian, Request $request)
    {
        $post = $request->post();
        $success_ = "";
        $errors_ = "";
        // dd($post);
        // dump($surat_pembelian);
        // VALIDASI TOTAL BUYBACK DAN TOTAL BAYAR
        $request->validate([
            'total_buyback' => 'required|numeric',
            'total_bayar' => 'required|numeric',
            'sisa_bayar' => 'required|numeric',
            'tipe_transaksi' => 'required',
        ]);
        $total_buyback = (float)$post['total_buyback'];
        $total_bayar = (float)$post['total_bayar'];
        $sisa_bayar = (float)$post['sisa_bayar'];
        if ($total_bayar < $total_buyback) {
            $request->validate(['error' => 'required'], ['error.required' => 'jumlah pembayaran ke pelanggan, kurang!']);
        }
        // END VALIDASI TOTAL BUYBACK DAN TOTAL BAYAR
        // dd($post);
        $user = Auth::user();
        $time_key = time();
        $kode_accounting = "$user->id.$time_key";

        $time_key = time();
        if (isset($post['locked'])) {
            $request->validate(['locked' => 'numeric']);
            $index_locked = (int)$post['locked'];
            $surat_pembelian_item = SuratPembelianItem::find($post['surat_pembelian_item_id'][$index_locked]);
            $harga_t = (float)$post['harga_t'][$index_locked] * 100;
            $berat_buyback = (float)$post['berat_buyback'] * 100;
            $potongan_ongkos = 0;
            if ($post['potongan_ongkos'][$index_locked]) {
                $potongan_ongkos = (float)$post['potongan_ongkos'][$index_locked] * 100;
            }

            $potongan_mata = 0;
            if ($post['potongan_mata'][$index_locked]) {
                $potongan_mata = (float)$post['potongan_mata'][$index_locked] * 100;
            }

            $potongan_rusak = 0;
            if ($post['potongan_rusak'][$index_locked]) {
                $potongan_rusak = (float)$post['potongan_rusak'][$index_locked] * 100;
            }

            $potongan_susut = 0;
            if ($post['potongan_susut'][$index_locked]) {
                $potongan_susut = (float)$post['potongan_susut'][$index_locked] * 100;
            }

            $potongan_lain = 0;
            if ($post['potongan_lain'][$index_locked]) {
                $potongan_lain = (float)$post['potongan_lain'][$index_locked] * 100;
            }

            $total_potongan = $potongan_ongkos + $potongan_mata + $potongan_rusak + $potongan_susut + $potongan_lain;
            $harga_buyback = $harga_t - $total_potongan;
            $post_harga_buyback = (float)$post['harga_buyback'][$index_locked] * 100;
            // dump($harga_buyback);
            // dump((string)$harga_buyback);
            // dd($post_harga_buyback);

            if ($harga_buyback != ($post_harga_buyback)) {
                $request->validate(['error' => 'requrired'], ['error.required' => "harga_buyback berbeda: $harga_buyback vs $post_harga_buyback"]);
            }

            $surat_pembelian_item->update([
                'locked_buyback' => 'yes',
                'status_buyback' => $post['status_buyback'][$index_locked],
                'kondisi_buyback' => $post['kondisi_buyback'][$index_locked],
                'berat_buyback' => (string)$berat_buyback,
                'potongan_ongkos' => (string)($potongan_ongkos),
                'potongan_mata' => (string)($potongan_mata),
                'potongan_rusak' => (string)($potongan_rusak),
                'potongan_susut' => (string)($potongan_susut),
                'potongan_lain' => (string)($potongan_lain),
                'total_potongan' => (string)($total_potongan),
                'harga_buyback' => (string)$harga_buyback,
                'keterangan_buyback' => $post['keterangan_buyback'][$index_locked],
                'tanggal_buyback' => date('Y-m-d', strtotime($post['hari'][$index_locked] . "-" . $post['bulan'][$index_locked] . "-" . $post['tahun'][$index_locked])) . 'T' . date('H:i:s', $time_key),
            ]);
            $success_ .= "-Buyback locked-";
            return back()->with('success_', $success_);
        } elseif (isset($post['unlocked'])) {
            $request->validate(['unlocked' => 'numeric']);
            $index_unlocked = (int)$post['unlocked'];
            $surat_pembelian_item = SuratPembelianItem::find($post['surat_pembelian_item_id'][$index_unlocked]);
            $surat_pembelian_item->locked_buyback = null;
            $surat_pembelian_item->save();
            $success_ .= "-Buyback unlocked-";
            return back()->with('success_', $success_);
        } elseif (isset($post['konfirmasi_buyback']) || is_null($post['konfirmasi_buyback'])) {
            // dump($post);
            // dd('masuk ke konfirmasi_buyback');
            $tanggal_buyback = '';
            foreach ($post['index_to_process'] as $key => $index_to_process) {
                if ($key === 0) {
                    $tanggal_buyback = date('Y-m-d', strtotime($post['hari'][$index_to_process] . "-" . $post['bulan'][$index_to_process] . "-" . $post['tahun'][$index_to_process])) . 'T' . date('H:i:s', $time_key);
                }
                $index_to_process = (int)$index_to_process;
                $surat_pembelian_item = SuratPembelianItem::find($post['surat_pembelian_item_id'][$index_to_process]);
                $harga_t = (float)$post['harga_t'][$index_to_process] * 100;
                $berat_buyback = (float)$post['berat_buyback'] * 100;
                $potongan_ongkos = 0;
                if ($post['potongan_ongkos'][$index_to_process]) {
                    $potongan_ongkos = (float)$post['potongan_ongkos'][$index_to_process] * 100;
                }

                $potongan_mata = 0;
                if ($post['potongan_mata'][$index_to_process]) {
                    $potongan_mata = (float)$post['potongan_mata'][$index_to_process] * 100;
                }

                $potongan_rusak = 0;
                if ($post['potongan_rusak'][$index_to_process]) {
                    $potongan_rusak = (float)$post['potongan_rusak'][$index_to_process] * 100;
                }

                $potongan_susut = 0;
                if ($post['potongan_susut'][$index_to_process]) {
                    $potongan_susut = (float)$post['potongan_susut'][$index_to_process] * 100;
                }

                $potongan_lain = 0;
                if ($post['potongan_lain'][$index_to_process]) {
                    $potongan_lain = (float)$post['potongan_lain'][$index_to_process] * 100;
                }

                $total_potongan = $potongan_ongkos + $potongan_mata + $potongan_rusak + $potongan_susut + $potongan_lain;
                $harga_buyback = $harga_t - $total_potongan;
                $post_harga_buyback = (float)$post['harga_buyback'][$index_to_process] * 100;
                // dump($harga_buyback);
                // dump((string)$harga_buyback);
                // dd($post_harga_buyback);

                if ($harga_buyback != ($post_harga_buyback)) {
                    $request->validate(['error' => 'requrired'], ['error.required' => "harga_buyback berbeda: $harga_buyback vs $post_harga_buyback"]);
                }
                // dump($surat_pembelian_item);
                // dd($surat_pembelian_item->surat_pembelian_id);
                $surat_pembelian_item->update([
                    'locked_buyback' => $post['locked_buyback'][$index_to_process],
                    'status_buyback' => $post['status_buyback'][$index_to_process],
                    'kondisi_buyback' => $post['kondisi_buyback'][$index_to_process],
                    'berat_buyback' => (string)$berat_buyback,
                    'potongan_ongkos' => (string)($potongan_ongkos),
                    'potongan_mata' => (string)($potongan_mata),
                    'potongan_rusak' => (string)($potongan_rusak),
                    'potongan_susut' => (string)($potongan_susut),
                    'potongan_lain' => (string)($potongan_lain),
                    'total_potongan' => (string)($total_potongan),
                    'harga_buyback' => (string)$harga_buyback,
                    'keterangan_buyback' => $post['keterangan_buyback'][$index_to_process],
                    'tanggal_buyback' => $tanggal_buyback,
                ]);
                $success_ .= "-Status buyback-";
                Accounting::create([
                    'kode_accounting' => $kode_accounting,
                    'surat_pembelian_id' => $surat_pembelian->id,
                    'surat_pembelian_item_id' => $surat_pembelian_item->id,
                    'nama_barang' => $surat_pembelian_item->longname,
                    'kadar' => $surat_pembelian_item->kadar,
                    'berat' => $surat_pembelian_item->berat,
                    'user_id' => $user->id,
                    'tipe' => 'pengeluaran',
                    'kategori' => 'Buyback Perhiasan',
                    'kategori_2' => null,
                    'deskripsi' => null,
                    'jumlah' => (string)$harga_buyback,
                ]);
                $success_ .= "-Accounting created-";
                // UPDATE STATUS BUYBACK SURAT_PEMBELIAN
                $jumlah_sudah_buyback = 0;
                foreach ($surat_pembelian->items as $surat_pembelian_item) {
                    if ($surat_pembelian_item->status_buyback) {
                        $jumlah_sudah_buyback++;
                    }
                }
                if ($jumlah_sudah_buyback) {
                    $surat_pembelian->tanggal_buyback = $tanggal_buyback;
                    $jumlah_item_pada_surat = count($surat_pembelian->items);
                    if ($jumlah_sudah_buyback === $jumlah_item_pada_surat) {
                        $surat_pembelian->status_buyback = 'all';
                    } elseif ($jumlah_sudah_buyback < $jumlah_item_pada_surat) {
                        $surat_pembelian->status_buyback = 'sebagian';
                    }
                    $surat_pembelian->save();
                    $success_ .= "-status_buyback dan tanggal_buyback pada surat_pembelian telah diupdate-";
                }
                // END UPDATE STATUS BUYBACK SURAT PEMBELIAN
            }
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
            Cashflow::create_cashflow($user->id, $time_key, $kode_accounting, $surat_pembelian_item->surat_pembelian_id, $post);
            $success_ .= "-Cashflow noted!-";
            return back()->with('success_', $success_);
        }

        dump($post);
        dd("tidak ada yang opsi yang sesuai");
    }

    function delete_customer(SuratPembelian $surat_pembelian) {
        $warnings_ = '';
        $surat_pembelian->pelanggan_id = null;
        $surat_pembelian->pelanggan_nama = null;
        $surat_pembelian->pelanggan_username = null;
        $surat_pembelian->pelanggan_nik = null;
        $surat_pembelian->save();
        $warnings_ .= '-Relasi dengan pelanggan dihapus-';
        $feedback = [
            'warnings_' => $warnings_
        ];
        return back()->with($feedback);
    }
}
