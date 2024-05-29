<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Menu;
use App\Models\Saldo;
use App\Models\SuratPembelian;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SuratPembelianController extends Controller
{
    function index() {
        $user = Auth::user();
        $cart = null;
        if ($user) {
            $cart = Cart::where('user_id', $user->id)->first();
        }

        $surat_pembelians = SuratPembelian::orderByDesc('created_at')->limit(200)->get();
        // my_decimal_format(100000);
        // my_decimal_format(100002);
        // my_decimal_format(100023);
        // dd('');
        // dd($surat_pembelians[0]->items);
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
            'back' => true,
            'backRoute' => 'home',
            'backRouteParams' => null,
            'surat_pembelians' => $surat_pembelians,
        ];
        // dd($data);
        return view('surats.index', $data);
    }

    function show(SuratPembelian $surat_pembelian) {
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
        ];
        // dd($data);
        return view('surats.show', $data);
    }

    function update_data_pelanggan(SuratPembelian $surat_pembelian, Request $request) {
        $post = $request->post();
        // dump($post);
        // dd($surat_pembelian);

        $success_ = "";

        $pelanggan = null;
        $error_cari_data_pelanggan = false;
        $feedback_cek_pelanggan = "";

        list($pelanggan, $error_cari_data_pelanggan, $feedback_cek_pelanggan) = User::cari_data_pelanggan($post['pelanggan_nama'], $post['pelanggan_username'], $post['pelanggan_nik']);

        if ($error_cari_data_pelanggan) {
            $request->validate(['error'=>'required'],['error.required'=>$feedback_cek_pelanggan]);
        }

        if ($pelanggan) {
            $surat_pembelian->pelanggan_id = $pelanggan->id;
            $surat_pembelian->pelanggan_nama = $pelanggan->nama;
            $surat_pembelian->pelanggan_username = $pelanggan->username;
            $surat_pembelian->pelanggan_nik = $pelanggan->nik;
            $surat_pembelian->save();
            $success_ .= "-Data pelanggan telah diupdate-";
        }

        $feedback = [
            "success_" => $success_
        ];

        return back()->with($feedback);
    }

    function print_out(SuratPembelian $surat_pembelian) {
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
        ];
        // dd($data);
        return view('surats.print-out', $data);
    }

    function delete(SuratPembelian $surat_pembelian) {
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

            $saldo = Saldo::where('kategori_wallet', $cashflow->kategori_wallet)->where('tipe_wallet', $cashflow->tipe_wallet)->where('nama_wallet', $cashflow->nama_wallet)->whereBetween("created_at", [$cashflow_date, $last_hour_of_date])->latest()->first();
            $jumlah_saldo = (int)$saldo->saldo_akhir;
            if ($cashflow->tipe == 'pengeluaran') {
                $saldo->saldo_akhir = (string)($jumlah_saldo + (int)$cashflow->jumlah);
                $saldo->save();
            } else if ($cashflow->tipe == 'pemasukan') {
                $saldo->saldo_akhir = (string)($jumlah_saldo - (int)$cashflow->jumlah);
                $saldo->save();
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
}
