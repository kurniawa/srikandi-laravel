<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Menu;
use App\Models\SuratPembelian;
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
}
