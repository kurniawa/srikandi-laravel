<?php

namespace App\Http\Controllers;

use App\Models\Cap;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\JenisPerhiasan;
use App\Models\Menu;
use App\Models\TipePerhiasan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    function index(User $user) {
        $cart = Cart::where('user_id', $user->id)->first();
        $cart_items = null;
        if ($cart) {
            $cart_items = $cart->cart_items;
        }


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
            'cart_items' => $cart_items,
        ];

        return view('carts.index', $data);
    }

    function pilih_tipe_barang($from) {
        // dd($from);

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
        ];

        return view('carts.pilih_tipe_barang', $data);
    }

    function create_item($from, $tipe_barang) {
        // dump($from);
        // dd($tipe_barang);
        $tipe_perhiasans = TipePerhiasan::all();
        $jenis_perhiasans = JenisPerhiasan::select('id', 'nama as label', 'nama as value', 'tipe_perhiasan_id')->get();
        $caps = Cap::select('id', 'nama as label', 'nama as value', 'codename')->get();
        // dd($tipe_perhiasans);
        // dd($jenis_perhiasans);

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
            'tipe_barang' => $tipe_barang,
            'tipe_perhiasans' => $tipe_perhiasans,
            'jenis_perhiasans' => $jenis_perhiasans,
            'caps' => $caps,
        ];

        // dd($caps);

        return view('carts.create_item', $data);
    }
}
