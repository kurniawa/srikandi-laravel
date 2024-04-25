<?php

namespace App\Http\Controllers;

use App\Models\Cap;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\JenisPerhiasan;
use App\Models\Mainan;
use App\Models\Mata;
use App\Models\Menu;
use App\Models\TipePerhiasan;
use App\Models\User;
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
        $tipe_perhiasans = TipePerhiasan::all();
        $jenis_perhiasans = JenisPerhiasan::select('id', 'nama as label', 'nama as value', 'tipe_perhiasan_id')->get();
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
        ];

        // dd($caps);

        return view('carts.checkout', $data);
    }

    function proses_checkout(Cart $cart, Request $request) {
        $post = $request->post();
        dump($cart);
        dd($post);
    }
}
