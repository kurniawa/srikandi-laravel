<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Menu;
use App\Models\SuratPembelian;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            'spk_menus' => Menu::get_spk_menus(),
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
        if ($surat_pembelian->pelanggan_id !== null) {
            $pelanggan = User::find($surat_pembelian->pelanggan_id);
            $pelanggan_nama = $pelanggan->nama;
            $pelanggan_username = $pelanggan->username;
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
            'spk_menus' => Menu::get_spk_menus(),
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
        if ($post['pelanggan_nama'] && $post['pelanggan_username']) {
            $pelanggan = User::where('nama', $post['pelanggan_nama'])->where('username', $post['pelanggan_username'])->first();
        } elseif ($post['pelanggan_nama']) {
            $pelanggan = User::where('nama', $post['pelanggan_nama'])->get();
            if (count($pelanggan) > 1) {
                $request->validate(['error'=>'required'],['error.required'=>'-lebih dari satu pelanggan ditemukan-']);
            } else {
                $pelanggan = $pelanggan[0];
            }
        } elseif ($post['pelanggan_username']) {
            $pelanggan = User::where('username', $post['pelanggan_username'])->first();
            if (!$pelanggan) {
                $request->validate(['error'=>'required'],['error.required'=>'-username tidak ditemukan-']);
            }
        }

        if ($pelanggan) {
            $surat_pembelian->pelanggan_id = $pelanggan->id;
            $surat_pembelian->pelanggan_nama = $pelanggan->nama;
            $surat_pembelian->save();
            $success_ .= "-Data pelanggan telah diupdate-";
        }

        $feedback = [
            "success_" => $success_
        ];

        return back()->with($feedback);
    }
}
